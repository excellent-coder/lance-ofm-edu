<?php

namespace App\Http\Controllers;

use App\Models\ExamCenter;
use App\Models\StudentActive;
use Illuminate\Http\Request;
use App\Models\Level;
use App\Models\Session;
use App\Models\StudentFee;
use App\Models\StudentPayment;
use Illuminate\Support\Str;

class StudentActiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($session = '')
    {
        if (!$session) {
            $session =  activeSession();
        }
        if (!$session) {
            $session = Session::firstOrFail();
        }

        $students = StudentActive::where('session_id', $session->id)->get();

        // return $students;
        return view('admin.pages.students.results.grade', compact('students', 'session'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth = auth('pgs')->user();
        if ($auth->activeSession) {
            return redirect()->route('pgs');
        }

        $level = Level::where('level', '>', $auth->level->level ?? 0)->orderBy('level', 'asc')->first();
        $fee = StudentFee::whereFee('tuition')
            ->where('session_id', activeSession()->id)
            ->where('level_id', $level->id)
            ->where('program_id', $auth->program_id)
            ->first();

        if (!$fee) {
            $fee = StudentFee::whereFee('tuition')
                ->where('session_id', activeSession()->id)
                ->where('program_id', $auth->program_id)
                ->first();
        }

        if (!$fee) {
            $fee = StudentFee::whereFee('tuition')
                ->where('session_id', activeSession()->id)
                ->first();
        }

        if (!$fee) {
            $fee = StudentFee::whereFee('tuition')->first();
        }
        if (!$fee) {
            // return redirect()->route('pgs');
        }
        // return $level;
        // return $fee;
        return view('frontend.pgs.payment.tuition', compact('level', 'fee'));
    }


    public function exam()
    {
        $centers = ExamCenter::whereActive(1)->get();

        $center = auth('pgs')->user()->activeSession->center ?? null;
        // return $center;
        return view('frontend.pgs.exam.register', compact('centers', 'center'));
    }

    public function examRegister(Request $request)
    {
        $session = activeSession();
        $user = auth('pgs')->user();
        $center = ExamCenter::findOrFail($request->center);
        $total = StudentActive::where('session_id', $session->id)
            ->where('exam_center_id', $center->id)
            ->where('level_id', $user->level_id)->count();
        if ($total > $center->capacity) {
            return [
                'message' => "$center->name is Filled up for this session exam, please try another center",
                'status' => 200,
                'type' => 'info'
            ];
        }
        $userCenter = $user->activeSession;
        $userCenter->exam_center_id = $center->id;
        $userCenter->save();
        return [
            'message' => 'You have successfully registerd to take your exam in this center',
            'desc' => 'You will be communicated via email',
            'status' => 200,
            'type' => 'success',
            'to' => route('pgs')
        ];
        return view('frontend.pgs.exam.register', compact('centers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, StudentFee $fee)
    {
        return $fee;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payFee(Request $request, StudentFee $fee)
    {
        $student = auth('pgs')->user();

        $payment = new StudentPayment();
        $payment->student_id = $student->id;
        $payment->amount = $fee->amount;
        $payment->currency =  $fee->currency;

        $payment->reason = $fee->reason;
        $payment->item = 'student_fees';
        $payment->item_id = $fee->id;

        do {
            $ref = 'ISAM-STU-FEE-' . Str::upper(Str::random(10));
        } while (StudentPayment::where('ref', $ref)->first());

        $payment->ref = $ref;
        $payment->ip = $request->ip();
        $mac = exec('getmac');
        $payment->mac = strtok($mac, ' ');
        $payment->device = $request->devce;

        $payment->save();

        $p = [
            'public_key' => config('services.rave.public_key'),
            'ref' => $ref,
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'country' => config('msc.country', 'NG'),
            'redirect' => route('pgs.fee.paid', $payment->id),
            'meta' => ['consumer_id' => $student->id, 'consumer_mac' => $mac],
            'customer' => [
                'email' => $student->email,
                'phone_number' => $student->phone,
                'reason' => $payment->reason,
                'user_id' => $student->id,
                'name' => "$student->name",
            ],
            'customization' => [
                'title' => $fee->reason,
                'description' => $fee->reason,
                'logo' => asset('storage/' . web_setting('general', 'logo', 'web/logo.png'))
            ],
        ];

        return [
            'message' => "Stay On the page to make Your payment",
            'desc' => 'Make payment',
            'type' => 'success',
            'status' => 200,
            'payment' => $p,
            // 'to' => '/scs'
        ];
    }

    public function paidFee(Request $request, StudentPayment $payment)
    {
        // return $payment->studentRequest;
        if ($payment->transaction_id) {
            // this payment has been processes,
            return redirect('/');
        }
        if ($request->tx_ref != $payment->ref) {
            // something is wrong we will come to you later
        }
        $payment->status = $request->status;
        $payment->transaction_id = $request->transaction_id;
        $payment->paid_at = date('Y-m-d H:i:s');
        $payment->save();

        // return $payment->fee;

        if ($payment->status == 'successful') {
            $auth = auth('pgs')->user();

            switch ($payment->fee->fee) {
                case 'tuition':
                    // upgrade student to next level
                    $level = Level::where('level', '>', $auth->level->level ?? 0)->orderBy('level', 'asc')->first();
                    if ($level) {
                        $sa = new StudentActive();
                        $sa->student_id = $auth->id;
                        $sa->session_id = activeSession()->id;
                        $sa->program_id = $auth->program_id;

                        $sa->level_id = $level->id;
                        $sa->payment_id = $payment->id;
                        $sa->save();

                        $auth->level_id = $level->id;
                        $auth->save();
                    }
                    break;
                case 'exam':
                    break;
            }

            // assign payment to student
            $request->session()->flash('paid.next_title', 'Dashboard');
            $request->session()->flash('paid.next', route('pgs'));
        }

        return view('frontend.payments.member', compact('payment'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentActive  $studentActive
     * @return \Illuminate\Http\Response
     */
    public function show(StudentActive $studentActive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentActive  $studentActive
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentActive $student)
    {
        // return $student;
        return view('admin.pages.students.results.edit-grade', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentActive  $studentActive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentActive $student)
    {
        $request->validate(['average' => 'required']);
        // return $request->all();

        $student->average = $request->average;
        $student->passed = $request->filled('passed');
        $student->save();

        return ['message' => 'student grade added', 'status' => 200, 'type' => 'success'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentActive  $studentActive
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentActive $studentActive)
    {
        //
    }
}
