<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Session;
use App\Models\StudentPayment;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StudentRequest;
use Illuminate\Support\Str;


class StudentPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function induction(StudentRequest $student)
    {
        if (!$student->approved_at || $student->paidInduction) {
            return view('errors.404');
        }
        $student->name = "$student->first_name $student->last_name";
        return view('frontend.payments.pgs.induction', compact('student'));
    }

    public function storeInduction(Request $request, StudentRequest $student)
    {
        $acceptance = web_setting('pgs', 'acceptance_fee');
        $matric = web_setting('pgs', 'matriculation_fee');
        $idCard = web_setting('pgs', 'id_card_fee');
        $handBook = web_setting('pgs', 'student_handbook_fee');
        $devLevy = web_setting('pgs', 'development_levy');

        $total = array_sum([$acceptance, $matric, $idCard, $handBook, $devLevy]);

        $payment = new StudentPayment();
        $payment->student_request_id = $student->id;
        $payment->amount = $total;
        $payment->currency =  web_setting('general', 'currency');
        $payment->reason = "Induction Fees";
        $payment->item = 'induction';

        do {
            $ref = 'ISAM-REG-STU-' . Str::upper(Str::random(10));
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
            'redirect' => route('pgs.induction.paid', $payment->id),
            'meta' => ['consumer_id' => $student->id, 'consumer_mac' => $mac],
            'customer' => [
                'email' => $student->email,
                'phone_number' => $student->phone,
                'reason' => $payment->reason,
                'user_id' => $student->id,
                'name' => "$student->last_name $student->first_name",
            ],
            'customization' => [
                'title' => "Acceptance Fee Payment",
                'description' => "Acceptance Fee Payment",
                'logo' => asset('storage/' . web_setting('general', 'logo', 'web/logo.png'))
            ],
        ];

        return [
            'message' => "Stay On the page to make Your payment",
            'desc' => 'Make payment to complete your registration',
            'type' => 'success',
            'status' => 200,
            'payment' => $p,
            // 'to' => '/scs'
        ];
    }


    public function paidInduction(Request $request, StudentPayment $payment)
    {
        // return $payment->studentRequest;
        if ($payment->transaction_id) {
            // this payment has been processes,
            // return redirect('/');
        }
        if ($request->tx_ref != $payment->ref) {
            // something is wrong we will come to you later
        }
        $payment->status = $request->status;
        $payment->transaction_id = $request->transaction_id;
        $payment->paid_at = date('Y-m-d H:i:s');
        $payment->save();

        if ($payment->status == 'successful') {
            $student = $payment->studentRequest;
            // create a new student
            $s = new Student();
            $s->student_request_id = $student->id;
            $s->name = "$student->last_name $student->first_name $student->middle_name";
            $s->email = $student->email;
            $s->phone = $student->phone;
            $s->program_id = $student->program_id;
            $s->passport = $student->passport;
            $session = Session::whereActive(1)->first();
            $year = $session->year ?? date('Y');
            $next = (int) Student::where('session_id', $session->id)
                ->where('program_id', $student->program_id)
                ->count() + 1;
            $s->session_id = $session->id;

            $len = strlen($next);
            if ($len < 4) {
                do {
                    $next = "0" . $next;
                    $len = strlen($next);
                } while ($len < 4);
            }
            $s->matric_no = "STU/" . $student->program->abbr . "/" . $year . "/" . $next;

            // student level
            $level = Level::orderBy('level', 'asc')->first();
            if ($level) {
                $s->level_id = $level->id;
            }

            $s->save();

            // assign payment to student
            $payment->student_id = $s->id;
            $payment->save();
            $request->session()->flash('paid.next_title', 'Choose Password');
            $request->session()->flash('paid.next', route('pgs.add-password', $s->id));
        }

        return view('frontend.payments.member', compact('payment'));
    }

    public function paid(Request $request, StudentPayment $payment)
    {
        return $payment;
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

        return view('frontend.payments.member', compact('payment'));
    }

    public function test(StudentRequest $student)
    {
        // return $student;
        $ap = $student;
        return view('emails.student.approve', compact('student'));
    }

    public function student(Student $student)
    {
        return $student;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentPayment  $studentPayment
     * @return \Illuminate\Http\Response
     */
    public function show(StudentPayment $studentPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentPayment  $studentPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentPayment $studentPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentPayment  $studentPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentPayment $studentPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentPayment  $studentPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentPayment $studentPayment)
    {
        //
    }
}
