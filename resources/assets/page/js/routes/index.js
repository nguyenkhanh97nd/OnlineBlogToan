import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

var prefix = ""

import ClientIndex from '../components/views/index/index'
import ClientPostIndex from '../components/views/post/index'
import ClientSubCateIndex from '../components/views/subcate/index'
import ClientCateIndex from '../components/views/cate/index'
import ClientProfileIndex from '../components/views/profile/index'
import ClientTestOnlineIndex from '../components/views/testonline/index'
import ClientLogin from '../components/views/auth/login'
import ClientRegister from '../components/views/auth/register'
import ClientFollow from '../components/views/follow/index'
import ClientSocialLearningIndex from '../components/views/social-learning/index'
import ClientSearchPostIndex from '../components/views/search/index'
import ClientVerifyEmail from '../components/views/auth/verify'
import ClientSetting from '../components/views/setting/index'
import ClientSocialLearningCateQuestion from '../components/views/social-learning/cate'
import ClientSocialLearningSubCateQuestion from '../components/views/social-learning/subcate'
import ClientCommentFeed from '../components/views/comment_feed/index'

import ClientPasswordEmail from '../components/views/auth/password/email'
import ClientPasswordReset from '../components/views/auth/password/reset'

const router = new VueRouter({

	routes: [
		{
			path: prefix + '/', name: 'ClientIndex',
			component: ClientIndex,
			meta: {
				forAll: true
			}
		},{
			path: prefix + '/login', name: 'ClientLogin',
			component: ClientLogin,
			meta: {
				forAll: true,
				forUser: false
			}
		},{
			path: prefix + '/register', name: 'ClientRegister',
			component: ClientRegister,
			meta: {
				forAll: true,
				forUser: false
			}
		}, {
			path: prefix + '/register/verify/:code', name: 'ClientVerifyEmail',
			component: ClientVerifyEmail,
			meta: {
				forAll: true,
				forUser: false
			}
		}, {
			path: prefix + '/follow', name: 'ClientFollow',
			component: ClientFollow,
			meta: {
				forAll: false
			}
		}, {
			path: prefix + '/search', name: 'ClientSearchPostIndex',
			component: ClientSearchPostIndex,
			meta: {
				forAll: true
			}
		}, {
			path: prefix + '/social-learning', name: 'ClientSocialLearningIndex',
			component: ClientSocialLearningIndex,
			meta: {
				forAll: true
			}
		}, {
			path: prefix + '/password/email', name: 'ClientPasswordEmail',
			component: ClientPasswordEmail,
			meta: {
				forAll: true,
				forUser: false
			}
		}, {
			path: prefix + '/password/reset/:code', name: 'ClientPasswordReset',
			component: ClientPasswordReset,
			meta: {
				forAll: true,
				forUser: false
			}
		}, {
			path: prefix + '/social-learning/:slugCateQuestion', name: 'ClientSocialLearningCateQuestion',
			component: ClientSocialLearningCateQuestion,
			meta: {
				forAll: true
			}
		}, {
			path: prefix + '/social-learning/:slugCateQuestion/:slugSubCateQuestion', name: 'ClientSocialLearningSubCateQuestion',
			component: ClientSocialLearningSubCateQuestion,
			meta: {
				forAll: true
			}
		}, {
			path: prefix + '/comment_feed/:slugFeed', name: 'ClientCommentFeed',
			component: ClientCommentFeed,
			meta: {
				forAll: false
			}
		}, {
			path: prefix + '/setting', name: 'ClientSetting',
			component: ClientSetting,
			meta: {
				forAll: false
			}
		}, {
			path: prefix + '/category/showSubcate/:slugCate', name: 'ClientCateIndex',
			component: ClientCateIndex,
			meta: {
				forAll: true
			}
		}, {
			path: prefix + '/:slugSubCate', name: 'ClientSubCateIndex',
			component: ClientSubCateIndex,
			meta: {
				forAll: true
			}
		}, {
			path: prefix + '/profile/:userslug', name: 'ClientProfileIndex',
			component: ClientProfileIndex,
			meta: {
				forAll: false
			}
		}, {
			path: prefix + '/testonline/:slugPost', name: 'ClientTestOnlineIndex',
			component: ClientTestOnlineIndex,
			meta: {
				forAll: false
			}
		}, {
			path: prefix + '/:slugSubCate/:slugPost', name: 'ClientPostIndex',
			component: ClientPostIndex,
			meta: {
				forAll: true
			}
		}
	],

	mode: 'history'

})
export default router