import Helper from "./helper"

export default class Modal {
    _element = null
    _modal = null
    _events = []

    constructor(selector) {
        if(selector instanceof Element) {
            this._element = selector
        } else if(Helper.isString(selector) && !Helper.isEmpty(selector)) {
            this._element = document.querySelector(selector)
            if(!this._element) {
                throw new Error(`Element with query selector ${selector} is not found`)
            }
        } else {
            throw new Error(`Selector is not supported`)
        }

        this._modal = new bootstrap.Modal(this._element)
    }

    static supportedEvent() {
        return ["hide", "hidden", "show", "shown"]
    }

    show() {
        this._modal.show()
    }

    hide() {
        this._modal.hide()
    }

    on(type, callback) {
        if(!this.constructor.supportedEvent().includes(type)) {
            throw new Error(`Event ${type} does not support`)
        }

        if(!Helper.isFunction(callback)) {
            throw new Error(`Callback must be function`)
        }

        const event = this._events.find(event => event.type == type)
        if(event) {
            this._element.removeEventListener(`${type}.bs.modal`, event.handler)
        }

        const handler = (e) => callback()
        this._events.push({
            type: type,
            callback: callback,
            handler: handler
        })

        this._element.addEventListener(`${type}.bs.modal`, handler)
    }

    async trigger(type) {
        const event = this._events.find(event => event.type == type)
        if(event) {
            await event.callback()
        }
    }
}