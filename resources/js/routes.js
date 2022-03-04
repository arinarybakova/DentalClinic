
const Home = ()=> import('./components/Home.vue')


// importing procedure components
const Create = ()=> import('./components/procedure/Create.vue')
const Display = ()=> import('./components/procedure/Display.vue')
const Edit = ()=> import('./components/procedure/Edit.vue')


export const routes = [
    {
        name: 'home',
        path: '/',
        component:Home
    },
    {
        name: 'createProcedure',
        path: '/create',
        component:Create
    },
    {
        name: 'displayProcedures',
        path: '/procedures',
        component:Display
    },
    {
        name: 'editProcedure',
        path: '/edit/:id',
        component:Edit
    },
];