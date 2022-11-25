const jqueryValidate = require('jquery-validation')
import { HttpHelper } from '../../helpers/HttpHelper'
import Helpers from '@/helpers/helpers'

export class AuthForm {
    constructor(useValidation = true) {
        this.formValidation = null
        this.useValidation = useValidation

        // this.formId = formId
        // this.formObj = jQuery(`#${formId}`)
        this.formAlertsClasss = 'form-alerts'
        this.formClass = 'auth-form'
        this.formObj = jQuery(`.${this.formClass}`)

        if (this.formObj.length === 0) return

        if (this.useValidation) {
            this.formValidation = jqueryValidate(this.formObj)
            this.formValidation.validate()
            this.loadJqueryValidatorLocale()
        }

        this.registerEvents()
    }

    registerEvents() {
        this.formObj.find(':input').on('keyup', (e) => {
            this.formValidation.valid()
        })

        this.formObj.on('submit', (e) => {
            e.preventDefault()
            this.sendForm(e)
        })
    }

    async sendForm(event) {
        const form = jQuery(event.target)
        const formData = form.serialize()
        const formAction = form.attr('action')
        const inputs = form.find(':input')
        const submitButton = form.find(':submit')
        const container = form.parent()
        const notices = container.find(`.${this.formAlertsClasss}`)

        if (this.useValidation) {
            if (!this.formValidation.valid()) return
        }

        console.log('form is valid', form, notices)

        notices.empty()

        inputs.prop('readonly', true)
        submitButton.prop('disabled', true)

        try {
            const response = await HttpHelper.post(formAction, formData)
            console.log(`FORM .${this.formClass}, response`, response)

            inputs.prop('readonly', false)
            submitButton.prop('disabled', false)

            if (!response.success) {
                notices.hide().html(response.data.errors).fadeIn()
                Helpers.scrollToElement(notices)
                // this.scrollToNotices(container)
            }

            if (response.data.successMsg) {
                notices.hide().html(response.data.successMsg).fadeIn()
                // this.scrollToNotices(container)
                Helpers.scrollToElement(notices)

                form.trigger('reset')
            }
        } catch (error) {
            console.error('Error', error)

            inputs.prop('readonly', false)
            submitButton.prop('disabled', false)

            if (error.responseJSON && error.responseJSON.data) {
                notices.hide().html(error.responseJSON.data.errors).fadeIn()
                // this.scrollToNotices(container)
                Helpers.scrollToElement(notices)
            }
        }
    }

    scrollToNotices(container) {
        const notices = container.find(`.${this.formAlertsClasss}`)

        jQuery('html, body')
            .stop()
            .animate(
                {
                    scrollTop: notices.offset().top - 120,
                },
                800,
                'swing'
            )
    }

    loadJqueryValidatorLocale() {
        if (['de-DE', 'de-DE-formal'].includes(jQuery('html').attr('lang'))) {
            require('jquery-validation/dist/localization/messages_de')
        }
        if (jQuery('html').attr('lang') === 'fr-FR') {
            require('jquery-validation/dist/localization/messages_fr')
        }
        if (jQuery('html').attr('lang') === 'es-ES') {
            require('jquery-validation/dist/localization/messages_es')
        }
        if (jQuery('html').attr('lang') === 'it-IT') {
            require('jquery-validation/dist/localization/messages_it')
        }
        if (jQuery('html').attr('lang') === 'nl-NL') {
            require('jquery-validation/dist/localization/messages_nl')
        }
        if (jQuery('html').attr('lang') === 'nl-be') {
            require('jquery-validation/dist/localization/messages_nl')
        }
        if (jQuery('html').attr('lang') === 'ru-RU') {
            require('jquery-validation/dist/localization/messages_ru')
        }
    }
}
