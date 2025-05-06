import SolarUISingleton from "../../../solaris/solar-ui-singleton"

(function() {
    // get solar ui instance
    const solarUI = SolarUISingleton.getInstance()
    const stage = solarUI.get("accounts-status")

    stage.on("click", async (data) => {
        // const save = async () => {
        //     console.log("Saving data...")
        //     await new Promise((resolve, reject) => {
        //         setTimeout(() => {
        //             resolve()
        //         }, 3000)
        //     })
        //     return Math.random() < 0.5
        // }

        // try {
        //     stage.disabled()
        //     if(!await save()) {
        //         console.log("Saving data fail...")
        //         return false
        //     }
        // } catch (error) {
        //     console.log({error})
        // } finally {
        //     stage.enabled()
        // }

        console.log("Saving data success...", {data})
    })

    // setTimeout(() => {
    //     stage.set(2)
    // }, 2000)



    
    // how to access solar ui component
    // const table = solarUI.get("account_table")
    // const modal = solarUI.get("account-modal")
    // const form = solarUI.get("account-modal-form")
    // const profilePicture = solarUI.get("account-modal-profile_picture")
    // const primaryContactLookup = solarUI.get("account-modal-primary_contact_id")

    // // example using lazy
    // // for adding custom event
    // // table.on("row created", (...args) => {
    // //     console.log("Row is created...", {args})
    // // })
    // // table.on("column created:name", (...args) => {
    // //     console.log("Column name created...", {args})
    // // })
    // // table.on("column render:name", (data, row) => {
    // //     return `<h1>${data}</h1>`
    // // })

    // table.init()

    // // on new clicked
    // table.on("new", () => {
    //     form.newMode()
    //     modal.show()
    // })

    // // on edit action clicked
    // table.on("edit", async (data, row) => {
    //     // example edit show modal
    //     form.editMode(data.id)
    //     await form.load(data.id, true)
    //     modal.show()

    //     // example edit open edit page
    //     // Helper.loadingPage(true)
    //     // window.location = `${BASE_URL}/example/account/edit-page/${id}`
    // })

    // // when profile picture success crop/upload
    // profilePicture.on("success", (res) => {
    //     form.setToFormData()
    //     form.addFile("profile_picture", res.blob, res.name)
    //     form.addData("image_height", res.height)
    //     form.addData("image_width", res.width)
    // })

    // // when form is submit, and success do something
    // form.on("success", () => {
    //     table.refresh()
    //     modal.hide()
    // })

    // // when modal is close
    // modal.on("hide", () => {
    //     form.reset(true)
    //     profilePicture.emptyPreview()
    // })

    // primaryContactLookup.on("change", (value) => {
    //     console.log({value})
    // })
})()