/**
 * Some helper functions for api calls with fetch
 */

export class MessageHelper {
    constructor() {
        this.messageClass = 'message__text'

        this.messageTextObj = jQuery(`.${this.messageClass}`)

        this.messageText = ''
    }

    setMessage(text, color) {
        this.removeColorClasses()

        if (!color) {
            color = 'info'
        }

        this.messageTextObj.html(text).addClass(`message-${color}`)
    }

    removeColorClasses() {
        this.messageTextObj
            .removeClass('message-error')
            .removeClass('message-info')
            .removeClass('message-success')
    }

    showMessage() {
        this.messageTextObj.removeClass('hidden')
    }

    hideMessage() {
        this.removeColorClasses()
        this.messageTextObj.addClass('hidden')
    }
}
