import Helper from "./helper"
import BaseInput from "./base-input"
import CheckboxInput from "./checkbox-input"
import DatePicker from "./date-picker"
import FieldInput from "./field-input"
import PasswordInput from "./password-input"
import RadioInput from "./radio-input"
import TextInput from "./text-input"
import SelectInput from "./select-input"
import SelectMultipleInput from "./select-multiple-input"
import LookupInput from "./lookup-input"
import TextareaInput from "./textarea-input"
import Button from "./button"
import OptionGroupInput from "./option-group-input"
import LazyLoadComponent from "./solar-lazy-ui"
import Form from "./form"
import SearchInput from "./search-input"
import Table from "./table"
import Modal from "./modal"
import ProfilePicture from "./profile-picture"
import Attachment from "./attachment"
import MaskInput from "./mask-input"
import Notes from "./notes"
import StageButtons from "./stage-button"

export default class SolarComponent {
    #ui = null
    #init = false
    constructor() {
        this.#ui = new Map()
    }

    init() {
        if(this.#init) {
            this.#ui.forEach((value, key) => {
                if(!(value instanceof LazyLoadComponent)) {
                    value.destroy()
                }
            })

            this.#ui.clear()
        }

        this.#initForm()
        this.#initStandalone()
        this.#initField()
        this.#initNotes()
        this.#initButton()
        this.#initModal()
        this.#initTable()
        this.#initProfilePicture()
        this.#initAttachment()
        this.#initStageButton()

        this.#init = true
        console.log("Hello, I'm SolarUI 😁. Your components are auto initiliaze and ready use 🚀")
    }

    #initStandalone() {
        const standaloneInputsQuery = `input[solar-ui]:not(div[solar-id][solar-ui="field"] input), 
            textarea[solar-ui]:not(div[solar-id][solar-ui="field"] textarea), 
            select[solar-ui]:not(div[solar-id][solar-ui="field"] select), 
            div[solar-ui="input:radio-group"][solar-id]:not(div[solar-id][solar-ui="field"] div), 
            div[solar-ui="input:checkbox-group"][solar-id]:not(div[solar-id][solar-ui="field"] div)`
        document.querySelectorAll(standaloneInputsQuery).forEach(el => {
            const uiIgnore = el.getAttribute('ignore')
            if(uiIgnore) {
                return
            }

            const uiType = el.getAttribute('solar-ui')
            const uiLazy = el.getAttribute('lazy')
            const uiId = !Helper.isEmpty(el.id) ? el.id : this.#generateId()
            switch (uiType) {
                case "input":
                    if(el.getAttribute("mask")) {
                        this.#ui.set(uiId, uiLazy ? new LazyLoadComponent(uiId, MaskInput, [el]) : new MaskInput(el))
                    } else {
                        this.#ui.set(uiId, uiLazy ? new LazyLoadComponent(uiId, TextInput, [el]) : new TextInput(el))
                    }

                    break

                case "input:password":
                    this.#ui.set(uiId, uiLazy ? new LazyLoadComponent(uiId, PasswordInput, [el]) : new PasswordInput(el))
                    break

                case "input:search":
                    this.#ui.set(uiId, uiLazy ? new LazyLoadComponent(uiId, SearchInput, [el]) : new SearchInput(el))
                    break

                case "input:date":
                case "input:datetime":
                case "input:time":
                    const pickerMode = uiType.split(":")[1]
                    this.#ui.set(uiId, uiLazy ? new LazyLoadComponent(uiId, DatePicker, [el, pickerMode]) : new DatePicker(el, pickerMode))
                    break

                case "input:checkbox":
                    this.#ui.set(uiId, uiLazy ? new LazyLoadComponent(uiId, CheckboxInput, [el]) : new CheckboxInput(el))
                    break

                case "input:radio":
                    this.#ui.set(uiId, uiLazy ? new LazyLoadComponent(uiId, RadioInput, [el]) : new RadioInput(el))
                    break

                case "input:radio-group":
                case "input:checkbox-group":
                    const groupType = uiType.split(":")[1].split("-")[0]
                    this.#ui.set(el.getAttribute('solar-id'), uiLazy ? new LazyLoadComponent(uiId, OptionGroupInput, [el, groupType])  : new OptionGroupInput(el, groupType))
                    break

                case "textarea":
                    this.#ui.set(uiId, uiLazy ? new LazyLoadComponent(uiId, TextareaInput, [el]) : new TextareaInput(el))
                    break

                case "select":
                    this.#ui.set(uiId, uiLazy ? new LazyLoadComponent(uiId, SelectInput, [el]) : new SelectInput(el))
                    break

                case "select:multiple":
                    this.#ui.set(uiId, uiLazy ? new LazyLoadComponent(uiId, SelectMultipleInput, [el]) : new SelectMultipleInput(el))
                    break

                case "select:lookup":
                    this.#ui.set(uiId, uiLazy ? new LazyLoadComponent(uiId, LookupInput, [el]) : new LookupInput(el))
                    break
            
                default:
                    console.warn(`UI Type ${uiType} not supported`, {el})
                    break
            }
        })
    }

    #initField() {
        document.querySelectorAll('div[solar-id][solar-ui="field"]').forEach(el => {
            const uiIgnore = el.getAttribute('ignore')
            if(uiIgnore) {
                return
            }

            const solarId = el.getAttribute('solar-id')
            const uiId = !Helper.isEmpty(solarId) ? solarId : this.#generateId()
            const uiLazy = el.getAttribute('lazy')

            this.#ui.set(uiId, uiLazy ? new LazyLoadComponent(uiId, FieldInput, [el]) : new FieldInput(el))
        })
    }

    #initForm() {
        const formQuery = `form[solar-ui]`
        document.querySelectorAll(formQuery).forEach(el => {
            const uiIgnore = el.getAttribute('ignore')
            if(uiIgnore) {
                return
            }

            const uiId = !Helper.isEmpty(el.id) ? el.id : this.#generateId()
            this.#ui.set(uiId, new Form(el))
        })
    }

    #initButton() {
        document.querySelectorAll('button[solar-ui]').forEach(el => {
            const uiIgnore = el.getAttribute('ignore')
            if(uiIgnore) {
                return
            }

            const uiId = !Helper.isEmpty(el.id) ? el.id : this.#generateId()
            this.#ui.set(uiId, new Button(el))
        })
    }

    #initModal() {
        document.querySelectorAll(`div[solar-ui="modal"]`).forEach(el => {
            const uiIgnore = el.getAttribute('ignore')
            if(uiIgnore) {
                return
            }

            const uiId = !Helper.isEmpty(el.id) ? el.id : this.#generateId()
            this.#ui.set(uiId, new Modal(el))
        })
    }

    #initTable() {
        document.querySelectorAll(`table[solar-ui="table"]`).forEach(el => {
            const uiIgnore = el.getAttribute('ignore')
            if(uiIgnore) {
                return
            }
            
            const uiId = !Helper.isEmpty(el.id) ? el.id : this.#generateId()
            this.#ui.set(uiId, new Table(el))
        })
    }

    #initProfilePicture() {
        document.querySelectorAll(`div[solar-ui="profile-picture"]`).forEach(el => {
            const uiIgnore = el.getAttribute('ignore')
            if(uiIgnore) {
                return
            }
            
            const uiLazy = el.getAttribute('lazy')
            const uiId = !Helper.isEmpty(el.id) ? el.id : this.#generateId()
            this.#ui.set(uiId, uiLazy ? new LazyLoadComponent(uiId, ProfilePicture, [el]) : new ProfilePicture(el))
        })
    }

    #initAttachment() {
        document.querySelectorAll(`div[solar-ui="attachment"]`).forEach(el => {
            const uiIgnore = el.getAttribute('ignore')
            if(uiIgnore) {
                return
            }
            
            const uiLazy = el.getAttribute('lazy')
            const uiId = !Helper.isEmpty(el.id) ? el.id : this.#generateId()
            this.#ui.set(uiId, uiLazy ? new LazyLoadComponent(uiId, Attachment, [el]) : new Attachment(el))
        })
    }
    
    #initNotes() {
        document.querySelectorAll(`div[solar-ui="notes"]`).forEach(el => {
            const uiIgnore = el.getAttribute('ignore')
            if(uiIgnore) {
                return
            }
            
            const uiLazy = el.getAttribute('lazy')
            const uiId = !Helper.isEmpty(el.id) ? el.id : this.#generateId()
            this.#ui.set(uiId, uiLazy ? new LazyLoadComponent(uiId, Notes, [el]) : new Notes(el))
        })
    }

    #initStageButton() {
        document.querySelectorAll(`div[solar-ui="stages"]`).forEach(el => {
            const uiIgnore = el.getAttribute('ignore')
            if(uiIgnore) {
                return
            }
            
            const uiLazy = el.getAttribute('lazy')
            const uiId = !Helper.isEmpty(el.id) ? el.id : this.#generateId()
            this.#ui.set(uiId, uiLazy ? new LazyLoadComponent(uiId, StageButtons, [el]) : new StageButtons(el))
        })
    }

    #generateId() {
        return `solar-ui-${Math.random().toString(36).substring(2, 9)}`
    }

    /**
     * Get SolarUI Component
     * @param {string} id 
     * @returns {BaseInput|FieldInput|TextInput|PasswordInput|CheckboxInput|RadioInput|OptionGroupInput|SelectInput|SelectMultipleInput|LookupInput|Button|Form|LazyLoadComponent}
     */
    get(id) {
        if(!this.#ui || !this.#ui?.has(id)) {
            return null
        }

        return this.#ui.get(id)
    }

    /**
     * Set add new or override existing SolarUI Componet
     * @param {string} id 
     * @param {BaseInput|FieldInput|TextInput|PasswordInput|CheckboxInput|RadioInput|OptionGroupInput|SelectInput|SelectMultipleInput|LookupInput|Button|Form|LazyLoadComponent} value 
     */
    set(id, value) {
        if(!this.#ui || !this.#ui?.has(id)) {
            throw new Error("Id is not found")
        }

        this.#ui.set(id, value)
    }
}