import SolarUISingleton from "../../solaris/solar-ui-singleton"

(function() {
    const SolarUI = SolarUISingleton.getInstance()
    console.log({SolarUI})

    const form = SolarUI.get("myForm")
    const btnLoad1 = SolarUI.get("btn_load1")
    const btnLoad2 = SolarUI.get("btn_load2")
    const btnLoading = SolarUI.get("btn_loading")
    const btnReset = SolarUI.get("btn_reset")
    const btnEnabled = SolarUI.get("btn_enabled")
    const btnDisabled = SolarUI.get("btn_disabled")

    const getRandomInt = (min, max) => {
        const minCeiled = Math.ceil(min)
        const maxFloored = Math.floor(max)
        return Math.floor(Math.random() * (maxFloored - minCeiled) + minCeiled)
    }

    const randomName = () => {
        const names = ["Andi", "Budi", "Citra", "Dewi", "Eka", "Fajar"]
        return names[Math.floor(Math.random() * names.length)] + ' ' + randomLastName()
    }
    const randomLastName = () => {
        const lastNames = ["Santoso", "Wijaya", "Rahma", "Putri", "Saputra"]
        return lastNames[Math.floor(Math.random() * lastNames.length)]
    }

    const randomBirthdate = () => {
        const start = new Date(1980, 0, 1)
        const end = new Date(2005, 0, 1)
        const date = new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()))
        return date
    }

    const randomGender = () => {
        const gender = SolarUI.get("form_gender")
        const genderOption = Array.from(gender._plugin._element.options)
            .filter(opt => opt.value != "")
            .map(opt => opt.value)

        return genderOption[getRandomInt(0, genderOption.length-1)]
    }

    const randomReligion = () => {
        const religion = SolarUI.get("form_religion")
        const religionOption = religion._plugin._options.map(opt => opt._element.id)

        return religionOption[getRandomInt(0, religionOption.length-1)]
    }

    const randomEmail = () => {
        const domains = ["example.com", "mail.com", "domain.co"]
        const name = Math.random().toString(36).substring(2, 10)
        const domain = domains[Math.floor(Math.random() * domains.length)]
        return `${name}@${domain}`
    }
    
    const randomPassword = () => {
        const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()"
        let pass = ""
        for (let i = 0; i < 12; i++) {
            pass += chars.charAt(Math.floor(Math.random() * chars.length))
        }
        return pass
    }

    btnLoad1.click((e) => {
        console.log("Button Load clicked...")
        console.log("Load with set manual field")

        SolarUI.get("form_name").set(randomName())
        SolarUI.get("form_birthdate").set(randomBirthdate())
        SolarUI.get("form_gender").set(randomGender())
        SolarUI.get("active").set(Math.random() < 0.5)
        SolarUI.get("form_email").set(randomEmail())
        SolarUI.get("form_password").set(randomPassword())
        SolarUI.get("form_religion").set(randomReligion())
    })

    btnLoad2.click((e) => {
        console.log("Button Load clicked...")
        console.log("Load with form load method")

        const data = {
            name: randomName(),
            birthdate: randomBirthdate(),
            gender: randomGender(),
            active: Math.random() < 0.5,
            email: randomEmail(),
            password: randomPassword(),
            religion: randomReligion()
        }
        form.load(data)
    })

    btnLoading.click((e) => {
        console.log("Button Loading clicked...")
        form.loading()
        setTimeout(() => {
            form.loading(false)
        }, 1500)
    })

    btnReset.click((e) => {
        console.log("Button Reset clicked...")
        form.reset(true)
    })

    btnEnabled.click((e) => {
        console.log("Button Enabled clicked...")
        form.enabled()
    })

    btnDisabled.click((e) => {
        console.log("Button Disabled clicked...")
        form.disabled()
    })
})()