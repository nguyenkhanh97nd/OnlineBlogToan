import Vue from 'vue'
import VueRouter from 'vue-router'

// Views


Vue.use(VueRouter)

var prefix = ""

import AdminCategoryIndex from '../components/views/category/index'
import AdminCategoryForm from '../components/views/category/form'

import AdminCateQuestionIndex from '../components/views/catequestion/index'
import AdminCateQuestionForm from '../components/views/catequestion/form'

import AdminSubCategoryIndex from '../components/views/subcategory/index'
import AdminSubCategoryForm from '../components/views/subcategory/form'

import AdminSubCateQuestionIndex from '../components/views/subcatequestion/index'
import AdminSubCateQuestionForm from '../components/views/subcatequestion/form'

import AdminPostsIndex from '../components/views/posts/index'
import AdminPostsForm from '../components/views/posts/form'

import AdminPendingPostsIndex from '../components/views/pendingPosts/index'
import AdminPendingPostsForm from '../components/views/pendingPosts/form'

import AdminQuestionsIndex from '../components/views/questions/index'
import AdminQuestionsForm from '../components/views/questions/form'

import AdminMembersIndex from '../components/views/member/index'
import AdminMembersForm from '../components/views/member/form'

import AdminMailIndex from '../components/views/mail/index'

import AdminCommentIndex from '../components/views/comment/index'

import AdminDataIndex from '../components/views/data/index'

import AdminDashboardIndex from '../components/views/dashboard/index'

const router = new VueRouter({
    routes: [

    	// Category Admin
        { path: prefix + '/admin/category/index', name: 'AdminCategoryIndex',
        	component:  AdminCategoryIndex,
          meta: {
            forAdmins: true
          }
        },
        { path: prefix + '/admin/category/edit/:id', name: 'AdminCategoryEdit',
        	component: AdminCategoryForm,
          meta: {
            mode: 'edit',
            forAdmins: true
          }
        },
       	{ path: prefix + '/admin/category/create', name: 'AdminCategoryCreate',
       		component: AdminCategoryForm,
          meta: {
            forAdmins: true
          }
        },

        { path: prefix + '/admin/catequestion/index', name: 'AdminCateQuestionIndex',
          component:  AdminCateQuestionIndex,
          meta: {
            forAdmins: true
          }
        },
        { path: prefix + '/admin/catequestion/edit/:id', name: 'AdminCateQuestionEdit',
          component: AdminCateQuestionForm,
          meta: {
            mode: 'edit',
            forAdmins: true
          }
        },
        { path: prefix + '/admin/catequestion/create', name: 'AdminCateQuestionCreate',
          component: AdminCateQuestionForm,
          meta: {
            forAdmins: true
          }
        },

       	// Subcategory Admin
       	{ path: prefix + '/admin/subcategory/index', name: 'AdminSubCategoryIndex',
        	component:  AdminSubCategoryIndex,
          meta: {
            forAdmins: true
          }
        },
        { path: prefix + '/admin/subcategory/edit/:id', name: 'AdminSubCategoryEdit',
        	component: AdminSubCategoryForm,
          meta: {
            mode: 'edit',
            forAdmins: true
          }
        },
       	{ path: prefix + '/admin/subcategory/create', name: 'AdminSubCategoryCreate',
       		component: AdminSubCategoryForm,
          meta: {
            forAdmins: true
          }
        },

        { path: prefix + '/admin/subcatequestion/index', name: 'AdminSubCateQuestionIndex',
          component:  AdminSubCateQuestionIndex,
          meta: {
            forAdmins: true
          }
        },
        { path: prefix + '/admin/subcatequestion/edit/:id', name: 'AdminSubCateQuestionEdit',
          component: AdminSubCateQuestionForm,
          meta: {
            mode: 'edit',
            forAdmins: true
          }
        },
        { path: prefix + '/admin/subcatequestion/create', name: 'AdminSubCateQuestionCreate',
          component: AdminSubCateQuestionForm,
          meta: {
            forAdmins: true
          }
        },

        // Post Admin
        { path: prefix + '/admin/posts/index', name: 'AdminPostsIndex',
          component:  AdminPostsIndex,
          meta: {
            forAdmins: true
          }
        },
        { path: prefix + '/admin/posts/edit/:id', name: 'AdminPostsEdit',
          component: AdminPostsForm,
          meta: {
            mode: 'edit',
            forAdmins: true
          }
        },
        { path: prefix + '/admin/posts/create', name: 'AdminPostsCreate',
          component: AdminPostsForm,
          meta: {
            forAdmins: true
          }
        },

        // Pending Post Admin
        { path: prefix + '/admin/pendingposts/index', name: 'AdminPendingPostsIndex',
          component:  AdminPendingPostsIndex,
          meta: {
            forAdmins: true
          }
        },
        { path: prefix + '/admin/pendingposts/edit/:id', name: 'AdminPendingPostsEdit',
          component: AdminPendingPostsForm,
          meta: {
            mode: 'edit',
            forAdmins: true
          }
        },

        // Questions Admin
        { path: prefix + '/admin/questions/index', name: 'AdminQuestionsIndex',
          component:  AdminQuestionsIndex,
          meta: {
            forAdmins: true
          }
        },
        { path: prefix + '/admin/questions/edit/:id', name: 'AdminQuestionsEdit',
          component: AdminQuestionsForm,
          meta: {
            mode: 'edit',
            forAdmins: true
          }
        },
        { path: prefix + '/admin/questions/create', name: 'AdminQuestionsCreate',
          component: AdminQuestionsForm,
          meta: {
            forAdmins: true
          }
        },

        // Members Admin
        { path: prefix + '/admin/member/index', name: 'AdminMembersIndex',
          component:  AdminMembersIndex,
          meta: {
            forAdmins: true
          }
        },
        { path: prefix + '/admin/member/edit/:id', name: 'AdminMembersEdit',
          component: AdminMembersForm,
          meta: {
            mode: 'edit',
            forAdmins: true
          }
        },
        { path: prefix + '/admin/member/create', name: 'AdminMembersCreate',
          component: AdminMembersForm,
          meta: {
            forAdmins: true
          }
        },

        // Mail Send
        { path: prefix + '/admin/mail/index', name: 'AdminMailIndex',
          component:  AdminMailIndex,
          meta: {
            forAdmins: true
          }
        },

        // Comment Admin
        { path: prefix + '/admin/comment/index', name: 'AdminCommentIndex',
          component:  AdminCommentIndex,
          meta: {
            forAdmins: true
          }
        },

        // Data Test Admin
        { path: prefix + '/admin/bdata/index', name: 'AdminDataIndex',
          component:  AdminDataIndex,
          meta: {
            forAdmins: true
          }
        },

        // Dashboard Admin
        { path: prefix + '/admin/dashboard/index', name: 'AdminDashboardIndex',
          component:  AdminDashboardIndex,
          meta: {
            forAdmins: true
          }
        },

        // Login Admin
        { path: prefix + '/admin/login', name: 'AdminLogin',
          meta: {
            forVisitors: true
          }
        },
    ],
    mode: 'history'
})

export default router