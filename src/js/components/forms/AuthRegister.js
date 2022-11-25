const jqueryValidate = require('jquery-validation')
import { HttpHelper } from '../helpers/HttpHelper'

export class AuthRegister {
    constructor() {
        this.ajaxUrl = window.pluginNameConfig.ajaxUrl
        this.ajaxActionRegister = 'custom_register_user'

        this.formId = '#register'
        this.formObj = jQuery(this.formId)

        // Css class names
        // this.registerFormClass = '.bamo-form.bamo-register form'
        // this.registerFormObj = jQuery(this.registerFormClass)

        // if (this.registerFormObj.length === 0) return

        // this.formValidation = jqueryValidate(this.registerFormObj)
        // this.formValidation.validate()

        this.registerEvents()
    }

    registerEvents() {
        // this.registerFormObj.on('submit', (e) => {
        //     e.preventDefault()
        //     this.loadJqueryValidatorLocale()
        //     this.sendForm(e)
        // })

        this.formObj.find('button.next').on('click', (e) => {
            console.log('next button clicked')

            const $button = jQuery(e.currentTarget)
            this.setNextStepActive($button)
        })
    }

    setNextStepActive($button) {
        const step = $button.closest('.step')
        const nextStep = step.next()

        console.log('STEP', step)
        console.log('STEP next', nextStep)

        if (nextStep.length === 0) return

        step.removeClass('active')
        step.attr('hidden', 'hidden')

        nextStep.addClass('active')
        nextStep.removeAttr('hidden')
    }
}
