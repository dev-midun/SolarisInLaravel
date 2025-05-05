"use strict";

import BaseInput from "./base-input";
import CheckboxInput from "./checkbox-input";
import DatePicker from "./date-picker";
import Helper from "./helper";
import LookupInput from "./lookup-input";
import MaskInput from "./mask-input";
import OptionGroupInput from "./option-group-input";
import PasswordInput from "./password-input";
import SelectInput from "./select-input";
import SelectMultipleInput from "./select-multiple-input";
import TextInput from "./text-input";
import TextareaInput from "./textarea-input";

export default class FieldInput extends BaseInput {
    _bindTo = null
    _label = null
    _input = null
    _message = null
    _plugin = null
    _config = null

    constructor(selector, config = null) {
        super(selector)

        this._id = this._element.getAttribute("solar-id")
        this._bindTo = this._element.getAttribute("solar-bind")
        if(Helper.isEmpty(this._bindTo)) {
            this._bindTo = this._id
        }

        this._label = this._element.querySelector("label")
        this._input = this._element.querySelector("[solar-ui]")
        this._message = this._element.querySelector(`#${this._id}-message`)
        this._required = this._element.getAttribute("required")
        this._config = config
        
        this.#initPlugin()
        this._visible = !this._element.classList.contains("d-none")
        
        this._error = this._message.classList.contains("invalid-feedback")
        if((this._error && !this._plugin.isError()) || (!this._error && this._plugin.isError())) {
            this._plugin.error()
            this._error = true
        }

        this._valid = this._message.classList.contains("valid-feedback")
        if((this._valid && !this._plugin.isValid()) || (!this._valid && this._plugin.isValid())) {
            this._plugin.valid()
            this._valid = true
        }

        this._disabled = this._element.getAttribute("disabled") ? true : false
        if((this._disabled && !this._plugin.isDisabled()) || (!this._disabled && this._plugin.isDisabled())) {
            this._plugin.disabled()
            this._disabled = true
        }

        this._plugin.on("change", (data) => {
            const isEmpty = Helper.isEmpty(data)

            if(this._error && !isEmpty) {
                this.resetValidation()
            } else if(this._required && isEmpty) {
                this.error()
                this.setMessage(`${this.getLabel()} is required`)
            }
        })
    }

    /**
     * get current value element
     * @returns {*}
     */
    get() {
        return this._plugin.get()
    }

    /**
     * set value element
     * @param {*} value 
     * @param {boolean} isSilent. trigger change event, default is false 
     */
    set(value, isSilent = false) {
        this._plugin.set(value, isSilent)
    }

    /**
     * add event to element
     * @param {string} type 
     * @param {Function} callback 
     */
    on(type, callback) {
        this._plugin.on(type, callback)
    }

    /**
     * trigger event manually
     * @param {string} type event type 
     * @param {*} data 
     */
    async trigger(type, data) {
        await this._plugin.trigger(type, data)
    }
    
    /**
     * make element required
     */
    required() {
        if(!this._required) {
            this._label.innerHTML = `${this.getLabel()} <span class="text-danger">*</span>`
        }

        super.required()
        this._plugin.required()
    }

    /**
     * make element optional
     */
    optional() {
        if(this._required) {
            this._label.innerHTML = this.getLabel()
        }

        super.optional()
        this._plugin.required()
    }

    disabled() {
        super.disabled()
        this._plugin.disabled()
    }

    enabled() {
        super.enabled()
        this._plugin.enabled()
    }

    valid() {
        this._error = false
        this._valid = true
        this._plugin.valid()
        this._message.classList.remove('invalid-feedback')
        this._message.classList.add('valid-feedback')
    }

    error() {
        this._error = true
        this._valid = false
        this._plugin.error()
        this._message.classList.remove('valid-feedback')
        this._message.classList.add('invalid-feedback')
    }

    isChanged() {
        return this._plugin.isChanged()
    }

    resetValidation() {
        this._plugin.resetValidation()
        this._message.classList.remove("valid-feedback", "invalid-feedback")
        this.setMessage(null)
        this._error = false
        this._valid = false
    }

    reset(isSilent = false) {
        this.resetValidation()
        this._plugin.reset(isSilent)
    }

    setMessage(message) {
        this._message.textContent = message ?? ""
    }

    /**
     * Get field label
     * @returns {string}
     */
    getLabel() {
        return this._label.childNodes[0].data.trim()
    }

    setLabel(label) {
        if(!this._required) {
            this._label.textContent = label
        } else {
            this._label.innerHTML = `${label} <span class="text-danger">*</span>`
        }
    }

    #initPlugin() {
        const uiType = this._input.getAttribute('solar-ui')
        switch (uiType) {
            case "input":
                if(this._input.getAttribute("mask")) {
                    this._plugin = new MaskInput(this._input)
                } else {
                    this._plugin = new TextInput(this._input)
                }
                
                break

            case "textarea":
                this._plugin = new TextareaInput(this._input)
                break

            case "input:password":
                this._plugin = new PasswordInput(this._input)
                this._message.classList.add("d-block")
                break

            case "input:date":
            case "input:datetime":
            case "input:time":
                this._plugin = new DatePicker(this._input, uiType.split(":")[1], this._config)
                this._label.addEventListener("click", (e) => {
                    this._plugin._pickerElement.focus()
                })
                break

            case "select":
                this._plugin = new SelectInput(this._input)
                break

            case "select:multiple":
                this._plugin = new SelectMultipleInput(this._input)
                break

            case "select:lookup":
                this._plugin = new LookupInput(this._input, this._config)
                this._label.addEventListener("click", (e) => {
                    this._plugin.open()
                })
                break

            case "input:checkbox":
                this._plugin = new CheckboxInput(this._input)
                break

            case "input:radio":
                this._plugin = new RadioInput(this._input)
                break

            case "input:radio-group":
            case "input:checkbox-group":
                const groupType = uiType.split(":")[1].split("-")[0]
                this._plugin = new OptionGroupInput(this._input, groupType)
                this._message.classList.add("d-block")
                break
        
            default:
                throw new Error(`UI Type ${uiType} is not supported`)
        }
    }
}