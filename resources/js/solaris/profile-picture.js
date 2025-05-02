import Cropper from 'cropperjs'
import 'cropperjs/dist/cropper.css'
import Compressor from 'compressorjs'
import Helper from './helper'
import axios from '../libs/axios'
import PhotoSwipeLightbox from "photoswipe/lightbox"
import PhotoSwipe from "photoswipe"
import "photoswipe/style.css"

export default class ProfilePicture {
    _element = null
    _events = []
    _id = null
    _img = null
    _input = null
    _max = null
    _uploadTo = null
    _paramName = null
    _preview = null
    _modalCrop = null
    _cropper = null
    _cropPreview = null

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
        this._img = this._element.querySelector("img")
        this._input = this._element.querySelector(`input[type="file"]`)
        this._max = parseInt(this._input.getAttribute("max") ?? 1)
        this._uploadTo = this._input.getAttribute("upload-to")
        this._paramName = this._input.getAttribute("param-name")

        this._preview = this._element.querySelector("a")
        if(this._preview) {
            const lightbox = new PhotoSwipeLightbox({
                gallery: `#${this._id} a`,
                pswpModule: PhotoSwipe
            })
            lightbox.init()
        }

        this.#createCropper()        
        this.on('change', (image) => {
            if(!image) {
                return
            }

            const validation = this.validation(image)
            if(!validation.success) {
                this._input.value = null
                Helper.errorAlert({title: "Oops! There was an error", message: validation.message})

                return
            }
            
            this.openCropper()
        })
    }

    /**
     * registered event to ProfilePicture
     * @param {string} type only change and success event
     * @param {Function} callback if type is change, callback will be pass File as arguments
     * @returns {ProfilePicture}
     */
    on(type, callback) {
        if(!["change", "success"].includes(type)) {
            throw new Error(`Event ${type} does not support`)
        }

        if(!Helper.isFunction(callback)) {
            throw new Error(`Callback must be function`)
        }

        this._events.push({
            type: type,
            callback: callback
        })

        if(type == 'change') {
            this._input.addEventListener(type, (e) => {
                callback(this.getRawFile())
            })
        }

        return this
    }

    /**
     * trigger any event available
     * @param {string} type 
     * @param {any} data default is File
     * @returns {void}
     */
    trigger(type, data) {
        this._events
            .filter(e => e.type == type)
            .forEach(e => e.callback(data ? data : this.getRawFile()))
    }

    /**
     * get input file
     * @returns {File}
     */
    getRawFile() {
        const files = this._input.files
        return files.length > 0 ? files[0] : null
    }

    /**
     * get image crop as canvas
     * @returns {HTMLCanvasElement}
     */
    getImageCrop() {
        return this._cropper?.getCroppedCanvas() ?? null
    }

    /**
     * Open modal cropper
     * @returns {void}
     */
    openCropper() {
        this._modalCrop.show()
    }

    /**
     * Close modal cropper
     * @returns {void}
     */
    closeCropper() {
        this._modalCrop.hide()
    }

    /**
     * crop and upload to server input/selected image, this method will be trigger success event
     * @returns {void}
     */
    async upload() {
        if(Helper.isEmpty(this._uploadTo)) {
            return
        }

        Helper.loadingPage(true)
        try {
            const rawFile = this.getRawFile()
            const imgName = rawFile.name
            const imgSize = rawFile.size

            let imgCrop = this.getImageCrop()
            const height = imgCrop.height
            const width = imgCrop.width

            imgCrop = await new Promise((resolve) => {
                imgCrop.toBlob((blob) => {
                    resolve(blob)
                }, 'image/webp')
            })

            let cropSize = imgCrop.size
            while (cropSize >= imgSize) {
                imgCrop = await this.compress(imgCrop)
                cropSize = imgCrop.size
            }

            const imgExt = imgName.substring(imgName.lastIndexOf(".") + 1)
            const newImgName = `${imgName.substring(0, imgName.length-imgExt.length)}.webp`
            
            const form = new FormData()
            form.append(this._paramName, imgCrop, newImgName)
            form.append("image_height", height)
            form.append("image_width", width)

            const req = await axios({
                url: this._uploadTo,
                method: 'POST',
                data: form
            })
            const res = req.data
            if(!res.success) {
                throw res.message
            }

            const imgBase64 = URL.createObjectURL(imgCrop)
            this._img.src = imgBase64
            if(!this._preview) {
                this.#createImgPreview(imgBase64, height, width)
            } else {
                this._preview.href = imgBase64
                this._preview.setAttribute('data-pswp-height', height)
                this._preview.setAttribute('data-pswp-width', width)
            }

            this.trigger('success', {upload: res, base64: imgBase64})
            this.closeCropper()
        } catch (error) {
            Helper.errorAlert({title: "Oops! There was an error", message: error, timeout: null})
        } finally {
            Helper.loadingPage(false)
        }
    }

    /**
     * crop input/selected image, this method will be trigger success event
     * @returns {void}
     */
    async crop() {
        Helper.loadingPage(true)
        try {
            const rawFile = this.getRawFile()
            const imgName = rawFile.name
            const imgSize = rawFile.size

            let imgCrop = this.getImageCrop()
            const height = imgCrop.height
            const width = imgCrop.width

            imgCrop = await new Promise((resolve) => {
                imgCrop.toBlob((blob) => {
                    resolve(blob)
                }, 'image/webp')
            })
            let cropSize = imgCrop.size

            while (cropSize >= imgSize) {
                imgCrop = await this.compress(imgCrop)
                cropSize = imgCrop.size
            }

            const imgBase64 = URL.createObjectURL(imgCrop)
            this._img.src = imgBase64
            if(!this._preview) {
                this.#createImgPreview(imgBase64, height, width)
            } else {
                this._preview.href = imgBase64
                this._preview.setAttribute('data-pswp-height', height)
                this._preview.setAttribute('data-pswp-width', width)
            }

            const imgExt = imgName.substring(imgName.lastIndexOf(".") + 1)
            const newImgName = `${imgName.substring(0, imgName.length-imgExt.length)}.webp`

            this.trigger('success', {
                blob: imgCrop,
                base64: imgBase64,
                name: newImgName,
                height: height,
                width: width
            })
            this.closeCropper()
        } catch (error) {
            Helper.errorAlert({title: "Oops! There was an error", message: error, timeout: null})
        } finally {
            Helper.loadingPage(false)
        }        
    }

    /**
     * compress image size, reduce quality to 80%, can only compress jpeg/webp file
     * @param {File|Blob} file  
     * @returns {Promise<File|Blob>}
     */
    async compress(file) {
        if(!["image/jpeg", "image/webp"].includes(file.type)) {
            throw new Error("Cannot compress this file, mime type must be image/jpeg or image/webp")
        }

        return await new Promise((resolve) => {
            new Compressor(file, {
                quality: 0.8,
                success: (result) => {
                    resolve(result)
                },
            })
        })
    }

    /**
     * valdiation image upload based on size and mime
     * @param {*} image 
     * @returns {Object}
     */
    validation(image) {
        let message = 'File is not valid.'
        let isValid = true

        if(!Helper.isFileSizeValid(image, this._max)) {
            isValid = false
            message += ` Maximum size is ${this._max} MB.`
        }

        if(!Helper.isFileMimeValid(image, 'image')) {
            isValid = false
            message += ' File must be image file.'
        }

        return {
            success: isValid,
            message: message
        }
    }

    refreshPreview(id, height, width) {
        this._img.src = `${BASE_URL}/images/thumbnail/${id}`
        if(this._preview) {
            this._preview.href = `${BASE_URL}/images/${id}`
            this._preview.setAttribute('data-pswp-height', height)
            this._preview.setAttribute('data-pswp-width', width)
        }
    }

    emptyPreview() {
        const imgDummy = new URL("../../assets/images/user-dummy-img.jpg", import.meta.url)
        this._img.src = imgDummy
        if(this._preview) {
            const parent = this._preview.parentNode
            while (this._preview.firstChild) {
                parent.insertBefore(this._preview.firstChild, this._preview);
            }

            this._preview.remove()
            this._preview = null
        }
    }

    #createImgPreview(source, height, width) {
        this._preview = document.createElement("a")
        this._preview.href = source
        this._preview.setAttribute('data-pswp-height', height)
        this._preview.setAttribute('data-pswp-width', width)
        this._preview.setAttribute('target', '_blank')

        this._img.parentNode.insertBefore(this._preview, this._img)
        this._preview.appendChild(this._img)

        const lightbox = new PhotoSwipeLightbox({
            gallery: `#${this._id} a`,
            pswpModule: PhotoSwipe
        })
        lightbox.init()
    }

    #createCropper() {
        const modalId = `${this._id}_modalCropper`
        const modalEl = document.createElement("div")
        modalEl.className = 'modal fade'
        modalEl.id = modalId
        modalEl.setAttribute('tabindex', '-1')
        modalEl.setAttribute('aria-hidden', 'true')
        modalEl.setAttribute('data-bs-backdrop', 'static')
        modalEl.setAttribute('data-bs-keyboard', 'false')

        modalEl.innerHTML = `<div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="cropper-img-container">
                        <img id="${this._id}_imgPreview">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="${this._id}_submit" type="button" class="btn btn-primary">${!Helper.isEmpty(this._uploadTo) ? "Upload" : "Crop"}</button>
                    <button type="button" class="btn btn-soft-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>`

        document.body.appendChild(modalEl)

        this._modalCrop = new bootstrap.Modal(modalEl)
        this._cropPreview = document.querySelector(`#${this._id}_imgPreview`)
        
        modalEl.addEventListener('show.bs.modal', (e) => {
            this._cropPreview.classList.add('d-none')
        })

        modalEl.addEventListener('shown.bs.modal', (e) => {
            const reader = new FileReader()
            reader.onload = (e) => {
                this._cropPreview.src = e.target.result    
                this._cropper = new Cropper(this._cropPreview, {
                    aspectRatio: 1,
                    viewMode: 2,
                    movable: false,
                    ready: () => {
                        this._cropPreview.classList.remove('d-none')
                    }
                })
            }
            reader.readAsDataURL(this.getRawFile())
        })
        
        modalEl.addEventListener('hidden.bs.modal', (e) => {
            this._input.value = null
            this._cropper.destroy()
        })

        document.querySelector(`#${this._id}_submit`).addEventListener('click', (e) => {
            if(!Helper.isEmpty(this._uploadTo)) {
                this.upload()
            } else {
                this.crop()
            }
        })
    }
}