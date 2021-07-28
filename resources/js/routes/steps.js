import { h } from 'vue';
import {RouterView} from 'vue-router'

import R1Step from '../components/ResultForms/FirstStep.vue'
import R2Step from '../components/ResultForms/SecondStep.vue'
import R3Step from '../components/ResultForms/ThirdStep.vue'
import R4Step from '../components/ResultForms/FourthStep.vue'

const ResultRoutes = [
    {
        path: '/admin/results/create',
        component: { render: () => h(RouterView) },
        children: [

            {
                path: '',
                component: R1Step
            },
            {
                path: '1',
                name: 'R1Step',
                component: R1Step
            },
            {
                path: '2',
                name: 'R2Step',
                component: R2Step
            },
            {
                path: '3',
                name: 'R3Step',
                component: R3Step
            },
            {
                path: '4',
                name: 'R4Step',
                component: R4Step
            },
        ]
    }
]



export default ResultRoutes;
