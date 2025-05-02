import Helper from "./helper"
import axios from "../libs/axios"
import SolarUISingleton from './solar-ui-singleton'
import SelectInput from "./select-input"
import SelectMultipleInput from "./select-multiple-input"
import LookupInput from "./lookup-input"
import DatePicker from "./date-picker"
import OptionGroupInput from "./option-group-input"
import FieldInput from "./field-input"
import { AxiosError } from "axios"
import BaseInput from "./base-input"
import Model from "./model"

export default class Form {
    _element = null
    _fields = []
    _excludeFields = []
    _buttons = []
    _validations = []
    _events = []
    _successAlertMessage = "Data saved successfully"
    _errorAlertMessage = "Oops! There was an error"
    _showSuccessAlert = true
    _showErrorAlert = true
    _method = null
    #method = null
    #action = null
    #model = null
    #id = null
    #type = "json"
    #isActive = true
    #customData = {}
    #file = {}

    /**
     * 
     * @param {string|HTMLFormElement} selector 
     */
    constructor(selector) {
        if(selector instanceof HTMLFormElement) {
            this._element = selector
        } else if(Helper.isString(selector) && !Helper.isEmpty(selector)) {
            this._element = document.querySelector(selector)
            if(!this._element) {
                throw new Error(`Element with query selector ${selector} is not found`)
            }

            if(!(this._element instanceof HTMLFormElement)) {
                throw new Error(`Selector is not Form Element`)
            }
        } else {
            throw new Error(`Selector is not Form Element`)
        }

        this.#getAllComponents()
        
        this.#model = this._element.getAttribute("model")
        this._method = this._element.querySelector(`input[type="hidden"][name="_method"]`)
        this.#method = this._method ? this._method.value.toUpperCase() : (this._element.method?.toUpperCase() ?? "POST")
        if(!["POST", "PUT", "PATCH"].includes(this.#method)) {
            throw new Error(`Method ${this.#method} is not support`)
        }

        this.#action = this._element.getAttribute("action") ?? ""
        if(Helper.isEmpty(this.#action) && this.#model) {
            this.#action = `${BASE_URL}/${this.#model.toLowerCase()}`
        }
        
        if(Helper.isEmpty(this.#action)) {
            throw new Error(`Url cannot be null or empty`)
        }

        this._element.addEventListener("submit", async (e) => {
            e.preventDefault()

            if(this.#isActive) {
                await this.submit()
            }
        })
        this._element.addEventListener("keypress", async (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                if(this.#isActive) {
                    await this.submit()
                }
            }
        })
        
        const submitButton = this._buttons.find(btn => btn.type == "submit")
        submitButton?.addEventListener("click", async (e) => {
            e.preventDefault()
            if(this.#isActive) {
                await this.submit()
            }
        })

        console.warn("If you will submit with upload file, change form type to form-data. Use form.setToFormData()")
    }
    
    static supportedEvent() {
        return ["submit", "success", "error", "fail"]
    }

    isEdit() {
        return ["PUT", "PATCH"].includes(this.#method)
    }

    editMode(type = "PUT", id = null) {
        this.#method = type
        this.#id = id
    }

    newMode() {
        this.#method = "POST"
        this.#id = null
    }

    /**
     * Add fields that will not be processed
     * @param {string|Array} fieldName 
     */
    exclude(fieldName) {
        if(Helper.isString(fieldName)) {
            this._excludeFields.push(fieldName)
        } else if(Array.isArray(fieldName)) {
            this._excludeFields = this._excludeFields.concat(fieldName)
        }

        return this
    }

    /**
     * Submit data to server
     * @returns {Promise<boolean>}
     */
    async submit() {
        Helper.loadingPage(true)
        const fields = this.#getAllField()
        let req = null

        this.disabled(fields)
        this.#isActive = false

        await this.trigger("submit", null)

        try {
            const validation = await this.validation(fields)
            if(!validation.success) {
                this.setErrors(validation.errors, fields)
                await this.trigger("fail", validation)

                return false
            }

            let data = this.getData(fields)
            if(Helper.isEmpty(data)) {
                throw new Error(`Data cannot be null or empty`)
            }

            req = await axios({
                method: this.#method,
                url: !this.isEdit() ? this.#action : (this.#id ? `${this.#action}/${this.#id}` : this.#action),
                data: data
            })
            const res = req.data
            if(!res.success) {
                if(res.message && !Helper.isEmpty(res.message)) {
                    throw new Error(res.message)
                }

                this.setErrors(res.errors, fields)
                await this.trigger("fail", res)
                return false
            }

            if(this._showSuccessAlert) {
                Helper.successAlert({title: this._successAlertMessage})
            }

            this.trigger("success", res)
        } catch (error) {
            console.error("Submit data error", {error})
            const errorMessage = error instanceof AxiosError ? error.response?.data?.message : error
            if(this._showErrorAlert) {
                Helper.errorAlert({title: this._errorAlertMessage, message: errorMessage, timeout: null})
            }

            this.trigger("error", error)

            return false
        } finally {
            this.enabled(fields)
            this.#isActive = true
            Helper.loadingPage(false)
        }

        return true
    }

    /**
     * Load form with data from object / model
     * @param {string|Object} data fill with object for manual, or fill with guid for get from model
     * @param {boolean} isSilent 
     * @param {Map<string, BaseInput>} _fields 
     * @returns {Promise<void>}
     */
    async load(data, isSilent = false, _fields = null) {
        this.reset(true, _fields)

        try {
            Helper.loadingPage(true)
            if(this.#model || Helper.isString(data)) {
                data = await Model.get(this.#model, data)
            }
    
            const fields = _fields ? _fields : this.#getAllField()
            fields.forEach((value, key) => {
                if(data.hasOwnProperty(key)) {
                    value.set(data[key], isSilent)
                }
            })
        } catch (error) {
            console.error("Error when load form with data", {error})
        } finally {
            Helper.loadingPage(false)
        }
    }

    /**
     * Reset all field
     * @param {boolean} isSilent 
     * @param {Map<string, BaseInput>} _fields 
     */
    reset(isSilent = false, _fields = null) {
        const fields = _fields ? _fields : this.#getAllField()
        fields.forEach(field => {
            field.reset(isSilent)
        })
    }

    /**
     * Disabled all field
     * @param {Map<string, BaseInput>} _fields 
     */
    disabled(_fields = null) {
        const fields = _fields ? _fields : this.#getAllField()
        fields.forEach(field => {
            field.disabled()
        })
    }

    /**
     * Enabled all field
     * @param {Map<string, BaseInput>} _fields 
     */
    enabled(_fields = null) {
        const fields = _fields ? _fields : this.#getAllField()
        fields.forEach(field => {
            field.enabled()
        })
    }

    //#region events

    /**
     * 
     * @param {string} type 
     * @param {Function} callback 
     * @returns {Form}
     */
    on(type, callback) {
        if(!this.constructor.supportedEvent().includes(type)) {
            throw new Error(`Event ${type} does not support`)
        }

        if(!Helper.isFunction(callback)) {
            throw new Error(`Callback must be function`)
        }

        const index = this._events.findIndex(event => event.type == type)
        if(index != -1) {
            this._events.splice(index, 1)
        }

        this._events.push({
            type: type,
            callback: callback,
        })

        return this
    }

    async trigger(type, data) {
        const event = this._events.find(event => event.type == type)
        if(event) {
            await event.callback(data)
        }
    }

    //#endregion

    //#region Validation

    /**
     * Set error message to field
     * @param {Object} errors 
     * @param {Map<string, BaseInput>} _fields 
     * @returns 
     */
    setErrors(errors, _fields = null) {
        const fields = _fields ? _fields : this.#getAllField()
        if(errors === null) {
            fields.forEach(field => {
                field.resetValidation()
            })

            return
        }
        
        if(!Helper.isObject(errors)) {
            throw new Error("Errors must be object")
        }

        for(const error in errors) {
            if(fields.has(error)) {
                const field = fields.get(error)
                field.error()

                if(field instanceof FieldInput) {
                    field.setMessage(errors[error])
                }
            }
        }
    }

    addValidation(key, callback) {
        const index = this._validations.findIndex(item => item.id == key)
        if(index == -1) {
            this._validations.push({
                id: key,
                validations: [callback]
            })   
        } else {
            this._validations[index].validations.push(callback)
        }

        return this
    }

    /**
     * 
     * @param {Map<string, BaseInput>} _fields 
     * @returns {Promise<{result: boolean, errors: Array}>}
     */
    async validation(_fields = null) {
        const errors = []
        const result = {
            success: true,
            errors: null
        }

        const fields = _fields ? _fields : this.#getAllField()
        fields.forEach(field => {
            if(field.isRequired()) {
                const requiredValidation = this.#requiredValidation(field)
                if(!requiredValidation.success) {
                    result.success = false
                    errors.push({
                        id: field instanceof FieldInput ? field._bindTo : field._id,
                        errors: [requiredValidation.message]
                    })
                }
            }
        })

        for (let i = 0; i < this._validations.length; i++) {
            const item = this._validations[i]
            const id = item.id

            try {
                if(!fields.has(id)) {
                    console.warn(`Field ${id} not found`)
                    continue
                }

                const field = fields.get(id)
                const value = field.get()
                const validations = item.validations
                for (let j = 0; j < validations.length; j++) {
                    const validation = validations[j]
                    const validationResult = await validation(value)
                    const isValid = validationResult.success
                    const message = validationResult.message

                    if(!isValid) {
                        result.success = false

                        const index = errors.findIndex(e => e.id == id)
                        if(index == -1) {
                            errors.push({
                                id: field instanceof FieldInput ? field._bindTo : field._id,
                                errors: [message]
                            })
                        } else {
                            errors[index].errors.push(message)
                        }
                    }
                }   
            } catch (error) {
                console.error(`Error when processing validation ${id}`, {error})
                continue
            }
        }
        
        if(!result.success && errors.length > 0) {
            result.errors = {}
            errors.forEach(e => {
                result.errors[e.id] = e.errors.join(". ")
            })
        }

        return result
    }

    /**
     * 
     * @param {BaseInput} field 
     * @returns 
     */
    #requiredValidation(field) {
        const value = field.get()
        const message = field instanceof FieldInput ? `${field.getLabel()} is required` : "This field is required"
        const isValid = !Helper.isEmpty(value)

        return {
            success: isValid,
            message: isValid ? null : message
        }
    }

    //#endregion

    //#region Data

    setToFormData() {
        this.#type = 'form-data'
        return this
    }

    setToJson() {
        this.#type = 'json'
        return this
    }
    
    /**
     * 
     * @param {Map<string, BaseInput>} _fields 
     * @returns 
     */
    getData(_fields = null) {
        const fields = _fields ? _fields : this.#getAllField()
        if(this.#type.toLowerCase() == 'json') {
            return this.#getJson(fields)
        }

        if(this.#type.toLowerCase() == 'form-data') {
            return this.#getFormData(fields)
        }

        return null
    }

    /**
     * 
     * @param {Map<string, BaseInput>} fields 
     * @returns {Object}
     */
    #getJson(fields) {
        const data = {}
        fields.forEach(field => {
            const id = field instanceof FieldInput ? field._bindTo : field._id
            const component = field instanceof FieldInput ? field._plugin : field
            const value = field.get()

            if((component instanceof SelectInput) && !(component instanceof SelectMultipleInput)) {
                data[id] = value?.id ?? null
            } else if(component instanceof SelectMultipleInput) {
                data[id] = value?.map(val => val.id) ?? null
            } else if(component instanceof LookupInput || component instanceof OptionGroupInput) {
                data[id] = value?.id ?? null
            } else if(component instanceof DatePicker) {
                data[id] = component.toString()
            } else {
                data[id] = value
            }
        })

        for(const cData in this.#customData) {
            data[cData] = this.#customData[cData]
        }

        return data
    }

    /**
     * 
     * @param {Map<string, BaseInput>} fields
     * @returns {FormData} 
     */
    #getFormData(fields) {
        const data = new FormData()
        fields.forEach(field => {
            const id = field instanceof FieldInput ? field._bindTo : field._id
            const component = field instanceof FieldInput ? field._plugin : field
            const value = field.get() ?? ""

            if((component instanceof SelectInput) && !(component instanceof SelectMultipleInput)) {
                data.append(id, value?.id ?? "")
            } else if(component instanceof SelectMultipleInput) {
                const selectMultiValue = value?.map(val => val.id) ?? ""
                data.append(id, selectMultiValue ? JSON.stringify(selectMultiValue) : "")
            } else if(component instanceof LookupInput || component instanceof OptionGroupInput) {
                data.append(id, value?.id ?? "")
            } else if(component instanceof DatePicker) {
                const datePickerValue = component.toString()
                data.append(id, Array.isArray(datePickerValue) ? JSON.stringify(datePickerValue) : datePickerValue)
            } else {
                data.append(id, value)
            }
        })

        for(const cData in this.#customData) {
            data.append(cData, this.#customData[cData])
        }

        for(const fData in this.#file) {
            data.append(fData, this.#file[fData].file, this.#file[fData].filename)
        }

        return data
    }

    /**
     * Add custom data to request
     * @param {string} key 
     * @param {*} value 
     */
    addData(key, value) {
        const fields = this.#getAllField()
        if(fields.has(key)) {
            throw new Error(`Cannot add ${key} because it is already registered`)
        }

        this.#customData[key] = value
        return this
    }

    /**
     * 
     * @param {string} key 
     * @param {File} file 
     * @param {string} filename 
     */
    addFile(key, file, filename) {
        const fields = this.#getAllField()
        if(fields.has(key)) {
            throw new Error(`Cannot add ${key} because it is already registered`)
        }

        this.#file[key] = {file: file, filename: filename}
        return this
    }

    /**
     * Delete custom data
     * @param {string} key 
     * @returns 
     */
    deleteData(key) {
        if(this.#customData.hasOwnProperty(key)) {
            delete this.#customData[key]
        }

        return this
    }
    
    /**
     * 
     * @returns {Map<string, BaseInput>}
     */
    #getAllField() {
        const solarUI = SolarUISingleton.getInstance()
        const map = new Map()
        this._fields.forEach(item => {
            if(!this._excludeFields.includes(item)) {
                const field = solarUI.get(item)
                map.set(field instanceof FieldInput ? field._bindTo : item, field)
            }
        })

        return map
    }

    //#endregion 

    //#region Alert

    setSuccessMessage(message) {
        if(!Helper.isString(message)) {
            throw new Error("Message must be string")
        }

        if(Helper.isEmpty(message)) {
            throw new Error("Message cannot be empty or null")
        }

        this._successAlertMessage = message
        return this
    }

    setErrorMessage(message) {
        if(!Helper.isString(message)) {
            throw new Error("Message must be string")
        }

        if(Helper.isEmpty(message)) {
            throw new Error("Message cannot be empty or null")
        }

        this._errorAlertMessage = message
        return this
    }

    showSuccessAlert() {
        this._showSuccessAlert = true
        return this
    }

    hiddenSuccessAlert() {
        this._showSuccessAlert = false
        return this
    }

    showErrorAlert() {
        this._showErrorAlert = true
        return this
    }

    hiddenErrorAlert() {
        this._showErrorAlert = false
        return this
    }

    //#endregion

    #getAllComponents() {
        const standaloneInputsQuery = `input[solar-ui]:not(div[solar-id][solar-ui="field"] input), 
            textarea[solar-ui]:not(div[solar-id][solar-ui="field"] textarea), 
            select[solar-ui]:not(div[solar-id][solar-ui="field"] select), 
            div[solar-ui="input:radio-group"][solar-id]:not(div[solar-id][solar-ui="field"] div), 
            div[solar-ui="input:checkbox-group"][solar-id]:not(div[solar-id][solar-ui="field"] div)`
        Array.from(this._element.querySelectorAll(standaloneInputsQuery)).forEach(el => {
            const uiType = el.getAttribute('solar-ui')
            if(["input:radio-group", "input:checkbox-group"].includes(uiType)) {
                this._fields.push(el.getAttribute('solar-id'))
            } else {
                this._fields.push(el.id)
            }
        })

        const fieldQuery = 'div[solar-id][solar-ui="field"]'
        Array.from(this._element.querySelectorAll(fieldQuery)).forEach(el => {
            this._fields.push(el.getAttribute('solar-id'))
        })

        const buttonQuery = 'button[solar-ui]'
        Array.from(this._element.querySelectorAll(buttonQuery)).forEach(el => {
            this._buttons.push(el.id)
        })
    }
}