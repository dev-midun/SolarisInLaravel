import axios from 'axios'
import Helper from '../solaris/helper'

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.interceptors.request.use(config => {
    if (['post', 'put', 'patch', 'delete'].includes(config.method)) {
        config.headers['X-CSRF-TOKEN'] = Helper.getCsrfToken()
    }

    config.headers['Accept'] = 'application/json'
  
    return config
}, error => {
    if (error.response && error.response.status === 401) {
        window.location.reload()
    }

    return Promise.reject(error)
})

export { axios as default }