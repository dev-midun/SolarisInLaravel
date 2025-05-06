import Quill from 'quill'
import Helper from './helper'

export default class Notes {
    _element = null
    _id = null
    _bindTo = null
    _editor = null

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

        this._id = this._element.id
        this._bindTo = this._element.getAttribute("solar-bind")
        if(Helper.isEmpty(this._bindTo)) {
            this._bindTo = this._id
        }

        this._editor = new Quill(this._element, {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'font': [] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'header': 1 }, { 'header': 2 }],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'script': 'sub' }, { 'script': 'super' }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'align': [] }],
                    ['image', 'video'],
                    ['clean']
                ]
            }
        })

        const value = this._element.getAttribute("value")
        if(!Helper.isEmpty(value)) {
            this.set(value)
        }
    }

    /**
     * get content from editor
     * @returns {Delta|string}
     */
    get() {
        return this._editor?.getContents() ?? null
    }

    getJson() {
        return this.isEmpty() ? "" : JSON.stringify(this.get())
    }

    isEmpty() {
        return this._editor?.getText().trim().length === 0
    }

    /**
     * get raw string html content
     * @returns {string}
     */
    getRaw() {
        return this._editor?.root.innerHTML ?? null
    }

    /**
     * set editor
     * @param {Object|string} delta
     */
    set(delta) {
        if(Helper.isEmpty(delta)) {
            this._editor.setContents([{ insert: '\n' }]);
        } else {
            if(Helper.isString(delta)) {
                try {
                    delta = JSON.parse(delta)
                } catch (error) {
                    throw new Error("Content must be valid json")
                }
            }

            if(!Helper.isObject(delta)) {
                throw new Error("Content must be object")
            }

            this._editor.setContents(delta)
        }
    }

    isDisabled() {
        return !this._editor.isEnabled()
    }

    disabled() {
        this._editor.enable(false)
    }

    enabled() {
        this._editor.enable()
    }

    reset() {
        this.set(null)
    }

    // #imageHandler() {
    //     const input = document.createElement('input')
    //     input.setAttribute('type', 'file')
    //     input.setAttribute('accept', 'image/*')
    //     input.click()

    //     input.onchange = async () => {
    //         const file = input.files[0]
    //         if (!file) {
    //             return
    //         }

    //         const formData = new FormData();
    //         formData.append('image', file);

    //         const response = await fetch('/quill/upload-image', {
    //           method: 'POST',
    //           headers: {
    //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    //           },
    //           body: formData
    //         });

    //         const data = await response.json();
    //         const range = quill.getSelection();
    //         quill.insertEmbed(range.index, 'image', data.url);
    //     };
    // }
}