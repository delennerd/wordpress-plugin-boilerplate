export class Popup {
    popupObj
    popupId
    popupIsOpen
    popupTriggerClass

    constructor() {
        // this.triggerInstanceIsCreated = false
        this.popupObj = null
        this.popupId = null

        this.popupIsOpen = false
        this.popupTriggerClass = 'open-popup'
        this.popupOpenClass = 'open'
        this.popupOpenAnimationClass = 'fade-in'
        this.popupCloseAnimationClass = 'fade'

        this.popupCloseTriggerClass = 'close-popup'

        this.popupOpenedEvent = new Event('popupOpened')
        this.popupIsOpeningEvent = new Event('popupIsOpening')

        this.#handleOpenTrigger()
        this.#handleClosePopupEvent()
    }

    getPopupId() {
        return this.popupId
    }

    #handleClosePopupEvent() {
        document.querySelector(`body`).addEventListener('closePopup', (e) => {
            if (this.popupId === null) return
            this.closePopup()
        })
    }

    #handleOpenTrigger() {
        const self = this

        if (window.popupTriggerInstanceIsCreated) return null

        window.popupTriggerInstanceIsCreated = true

        jQuery(`.${this.popupTriggerClass}`).on('click', (event) => {
            event.preventDefault()
            const button = jQuery(event.currentTarget)
            const buttonPopupId = button.attr('data-popup-id')
            this.popupId = buttonPopupId
            this.popupObj = jQuery(`#${this.popupId}`)

            // console.warn(`Hello from #${this.popupId}`)

            if (this.popupObj.length === 0) {
                return null
            }

            this.openPopup(button)

            this.#handleCloseTrigger()

            // document.querySelector(`.${this.popupTriggerClass}`).dispatchEvent(this.popupOpenedEvent)
            document.querySelector('body').dispatchEvent(this.popupOpenedEvent)
        })
    }

    #handleCloseTrigger() {
        const self = this

        // Close popup by clicking out
        // Close by clicking on "verwerfen"
        jQuery(`.${this.popupCloseTriggerClass}`).on('click', (e) => {
            e.preventDefault()
            this.closePopup()
        })

        jQuery(document).on('keydown', (event) => {
            if (event.key == 'Escape') {
                self.closePopup()
            }
        })

        jQuery(document).on('mouseup', (event) => {
            const container = self.popupObj.find('.popup-inner')

            if (
                !container.is(event.target) &&
                container.has(event.target).length === 0
            ) {
                this.closePopup()
            }
        })
    }

    openPopup(triggerButton = null) {
        if (this.popupIsOpen) return

        console.log(`Open popup #${this.popupId}`)

        const popupIsOpeningEvent = new CustomEvent('popupIsOpening', {
            "detail": {
                button: triggerButton
            },
        })

        document
            .querySelector(`#${this.popupId}`)
            .dispatchEvent(popupIsOpeningEvent)

        jQuery('body').addClass('popup-open')

        this.popupIsOpen = true

        this.popupObj.removeAttr('hidden')
        this.popupObj.addClass(`${this.popupOpenClass}`)
    }

    closePopup(skipPopupOpenCheck = false) {
        // console.log('Close popup...')

        if (this.popupIsOpen === false && skipPopupOpenCheck === false) return
        if (!this.popupObj) return

        jQuery('body').removeClass('popup-open')

        this.popupObj.removeClass(`${this.popupOpenClass}`)

        setTimeout(() => {
            this.popupObj.attr('hidden', 'hidden')
        }, 500)

        this.popupIsOpen = false

        jQuery('body').trigger('focus')
    }

    loadJqueryValidatorLocale() {
        if (jQuery('html').attr('lang') === 'de-DE') {
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

    validateForm(inputs = new Array()) {
        if (inputs.length === 0) {
            inputs = jQuery(`form#${this.formId} [data-validation*="required"]`)
        }

        const requiredMessage = `<span class="help-block error">Dies ist ein Pflichtfeld</span>`
        const errorMessageClass = `help-block`

        let hasError = false

        inputs.each((index, input) => {
            const _input = jQuery(input)

            const errorMessage = jQuery(`.${errorMessageClass}`)
            const hasErrorMessage = errorMessage.length > 0

            if (_input.val().trim().length === 0) {
                hasError = true

                if (hasErrorMessage) return false
                _input.after(requiredMessage)

                return false
            }

            _input.next(`.${errorMessageClass}`).remove()

            hasError = false
        })

        return !hasError
    }

    validateFormAfterKeyboardEvents() {
        jQuery(`form#${this.formId} [data-validation*="required"]`).on(
            'keyup',
            (e) => {
                this.validateForm(jQuery(e.currentTarget))
            }
        )
    }
}
