import Dropzone from "dropzone"
import Helper from "./helper"
import axios from "../libs/axios"
import PhotoSwipeLightbox from "photoswipe/lightbox"
import PhotoSwipe from "photoswipe"
import "photoswipe/style.css"
import SolarUISingleton from "./solar-ui-singleton"

export default class Attachment {
    _element = null
    _id = null
    _upload = null
    _table = null
    _chunkSize = 2000000

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
        this._chunkSize = parseInt(this._element.getAttribute("chunk-size") ?? this._chunkSize)
        this._upload = this._element.querySelector(`#${this._id}_upload`)

        setTimeout(() => {
            this.#initTable()
            this.#initUpload()
        }, 0)
    }

    #initTable() {
        const solarUI = SolarUISingleton.getInstance()
        const availMimes = Helper.getAvailableMime()
        const imgExt = availMimes.filter(item => item.type == 'image').map(item => item.ext.substring(1))
        const archiveExt = availMimes.filter(item => item.type == 'compress').map(item => item.ext.substring(1))

        const imgDummy = {
            archive: new URL("../../assets/images/attachment/archive.png", import.meta.url),
            file: new URL("../../assets/images/attachment/file.png", import.meta.url),
            pdf: new URL("../../assets/images/attachment/pdf.png", import.meta.url),
            word: new URL("../../assets/images/attachment/word.png", import.meta.url),
            excel: new URL("../../assets/images/attachment/excel.png", import.meta.url),
            ppt: new URL("../../assets/images/attachment/powerpoint.png", import.meta.url),
            text: new URL("../../assets/images/attachment/txt.png", import.meta.url)
        }

        this._table = solarUI.get(`${this._id}_table`)
        this._table.on("draw", () => {
            const lightbox = new PhotoSwipeLightbox({
                gallery: `#${this._id}_table tbody tr td a.img-preview`,
                pswpModule: PhotoSwipe
            })
            lightbox.init()
        })
        .on("column render:file_name", (data, row) => {
            let isImage = false
            let imgSrc = null
            if(imgExt.includes(`${row.file_extension.toLowerCase()}`)) {
                imgSrc = `${BASE_URL}/images/thumbnail/${row.id}`
                isImage = true
            } else if(archiveExt.includes(`${row.file_extension.toLowerCase()}`)) {
                imgSrc = imgDummy.archive
            } else if(row.file_extension.toLowerCase() == 'pdf') {
                imgSrc = imgDummy.pdf
            } else if(row.file_extension.toLowerCase() == 'txt') {
                imgSrc = imgDummy.text
            } else if(row.file_extension.toLowerCase() == 'docx') {
                imgSrc = imgDummy.word
            } else if(['xlsx', 'csv'].includes(row.file_extension.toLowerCase())) {
                imgSrc = imgDummy.excel
            } else if(row.file_extension.toLowerCase() == 'pptx') {
                imgSrc = imgDummy.ppt
            } else {
                imgSrc = imgDummy.file
            }

            return `<div class="d-flex gap-2">
                ${isImage ? `<a class="img-preview" href="${BASE_URL}/images/${row.id}" data-pswp-width="${row.image_width}" data-pswp-height="${row.image_height}" target="_blank">` : ''}
                    <img class="img-fluid rounded d-block" src="${imgSrc}" alt="image" width="36">
                ${isImage ? '</a>' : ''}
                <div class="d-flex flex-column flex-shrink-1">
                    <p class="mb-0">${row.file_name}</p>
                    <p class="text-muted mb-0">${row.file_size_human ?? row.file_size}</p>
                </div>
            </div>`
        })
        .on("column created:_action", (td, cellData, rowData) => {
            const downloadElem = document.createElement("a")
            downloadElem.className = "dropdown-item download-action"
            downloadElem.href = "javascript:void(0)"
            downloadElem.innerHTML = `<i class="ri-download-2-line me-1"></i>Download`
            downloadElem.addEventListener("click", (e) => this.download(rowData.id))

            td.querySelector(".dropdown ul.dropdown-menu").prepend(downloadElem)
        })
        .init()
    }
    
    #initUpload() {
        const availMimes = Helper.getAvailableMime()
        const availExt = [...new Set(availMimes.map(item => item.ext))]
        const imgMimes = availMimes.filter(item => item.type == 'image').map(item => item.mime)

        const scope = this
        new Dropzone(this._upload, {
            url: `${BASE_URL}/attachment/`,
            headers: {
                "X-CSRF-TOKEN": Helper.getCsrfToken()
            },
            method: "post",
            paramName: "file",
            chunking: true,
            forceChunking: true,
            chunkSize: this._chunkSize,
            retryChunks: true,
            retryChunksLimit: 3,
            parallelUploads: 1,
            maxFilesize: MAX_FILE_SIZE,
            acceptedFiles: availExt.join(","),
            accept: function(file, done) {
                if(imgMimes.includes(file.type)) {
                    const reader = new FileReader()
                    reader.onload = function (e) {
                        const img = new Image()
                        img.onload = function () {
                            file.width = img.width
                            file.height = img.height

                            done()
                        }
                        img.src = e.target.result
                    }
                    reader.readAsDataURL(file)
                } else {
                    done()
                }
            },
            init: function() {
                const removeFile = (file) => {
                    scope._table.refresh()
                    setTimeout(() => {
                        file.previewElement.style.transition = "opacity 0.5s ease-out"
                        file.previewElement.style.opacity = "0"
                        setTimeout(() => {
                            this.removeFile(file)
                        }, 500)
                    }, 2000)
                }

                this.on("sending", function(file, xhr, formData) {
                    formData.append("param_name", "file")

                    const filter = scope._table._initFilter
                    filter.forEach(f => {
                        const filterSplit = f.split(":")
                        formData.append(filterSplit[0], filterSplit[1])
                    })

                    if(imgMimes.includes(file.type)) {
                        formData.append('thumbnail', 'true')
                        if (file.width && file.height) {
                            formData.append('image_height', file.height)
                            formData.append('image_width', file.width)
                        }
                    }
                })

                this.on("success", function(file, response) {
                    removeFile(file)
                })

                this.on("error", function(file, message) {
                    removeFile(file)
                })
            }
        })
    }

    async refresh() {
        this._table.refresh()
    }

    async download(id) {
        const req = await axios({
            method: "GET",
            url: `${BASE_URL}/attachment/download/${id}`,
            responseType: 'blob'
        })
        const contentDisposition = req.headers['content-disposition']
        const contentDispositionSplit = contentDisposition.split(';')
        const fileName = contentDispositionSplit[1].trim().replaceAll('"', "").replaceAll("'", "").substring(9)

        const url = window.URL.createObjectURL(req.data)
        const a = document.createElement('a')
        a.href = url
        a.download = fileName
        document.body.appendChild(a);
        a.click();    
        a.remove();
    }
}