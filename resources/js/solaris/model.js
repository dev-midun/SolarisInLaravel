import { AxiosError } from "axios"
import axios from "../libs/axios"
import Helper from "./helper"

export default class Model {
    static async get(endpoint, id) {
        if(!Helper.isString(endpoint) || Helper.isEmpty(endpoint)) {
            throw new Error("Endpoint must be string and cannot empty")
        }

        if(!Helper.isString(id) || Helper.isEmpty(id)) {
            throw new Error("Id must be string and cannot empty")
        }

        try {
            const req = await axios({
                method: "GET",
                url: Model.url(`${endpoint}/${id}`)
            })

            return req.data
        } catch (error) {
            console.error({error})
        }

        return null
    }

    static async getList(endpoint, {search, orderBy = 'created_at', direction = 'desc', page = 1, length = 10}) {
        if(!Helper.isString(endpoint) || Helper.isEmpty(endpoint)) {
            throw new Error("Endpoint must be string and cannot empty")
        }

        if(!Helper.isString(id) || Helper.isEmpty(id)) {
            throw new Error("Id must be string and cannot empty")
        }

        try {
            const req = await axios({
                method: "GET",
                url: Model.url(`${endpoint}/${id}`),
                data: {
                    search: search,
                    orderBy: orderBy,
                    direction: direction,
                    page: page,
                    length: length
                }
            })

            return req.data
        } catch (error) {
            console.error({error})
        }

        return []
    }

    static async create(endpoint, data) {
        if(!Helper.isString(endpoint) || Helper.isEmpty(endpoint)) {
            throw new Error("Endpoint must be string and cannot empty")
        }

        if(!Helper.isObject(data)) {
            throw new Error("Data must be object")
        }

        try {
            const req = await axios({
                method: "POST",
                url: Model.url(endpoint),
                data: data
            })
            const res = req.data
            return res.success
        } catch (error) {
            console.error({error})
            
            throw error
        }
    }

    static async update(endpoint, id, data) {
        if(!Helper.isString(endpoint) || Helper.isEmpty(endpoint)) {
            throw new Error("Endpoint must be string and cannot empty")
        }

        if(!Helper.isString(id) || Helper.isEmpty(id)) {
            throw new Error("Id must be string and cannot empty")
        }
        
        if(!Helper.isObject(data)) {
            throw new Error("Data must be object")
        }

        try {
            const req = await axios({
                method: "PUT",
                url: Model.url(`${endpoint}/${id}`),
                data: data
            })

            return req.data
        } catch (error) {
            console.error({error})

            throw error
        }
        
    }

    static async delete(endpoint, id, config = null) {
        if(!Helper.isString(endpoint) || Helper.isEmpty(endpoint)) {
            throw new Error("Endpoint must be string and cannot empty")
        }

        if(!Helper.isString(id) || Helper.isEmpty(id)) {
            throw new Error("Id must be string and cannot empty")
        }
        
        const conf = config
        const confirm = conf?.confirm ?? true
        const confirmMessage = conf?.message ?? "Are you sure?"
        const successMessage = conf?.success ?? "Delete data successfully"
        const errorMessage = conf?.error ?? "Oops! There was an error"
        const loading = conf?.loading ?? true

        if(typeof confirm !== 'boolean') {
            throw new Error("Confirm must be boolean")
        }
        
        if(confirm) {
            const conf = await Helper.confirmDelete({title: confirmMessage})
            if(!conf) {
                return null
            }
        }

        if(loading) {
            Helper.loadingPage(true)
        }

        try {
            const req = await axios({
                method: "DELETE",
                url: Model.url(`${endpoint}/${id}`)
            })
            const res = req.data
            if(res.success && !Helper.isEmpty(successMessage)) {
                Helper.successAlert({title: successMessage})
            }

            return res.success
        } catch (e) {
            console.error({e})
            
            if(!Helper.isEmpty(errorMessage)) {
                const eMessage = e instanceof AxiosError ? e.response?.data?.message : e
                Helper.errorAlert({title: errorMessage, message: eMessage, timeout: null})
            }

            throw e
        } finally {
            if(loading) {
                Helper.loadingPage(false)
            }
        }
    }

    static url(endpoint) {
        return new URL(endpoint.toLowerCase(), BASE_URL+"/").href
    }
}