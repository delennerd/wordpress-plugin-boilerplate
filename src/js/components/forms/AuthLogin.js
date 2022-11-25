export class AuthLogin {
    constructor() {
        this.submitButtonClass = ''
        this.formClass = '.login-form'

        this.handleLoginButton()
    }

    handleLoginButton() {
        jQuery(`${this.formClass}`).on('submit', (e) => {
            e.preventDefault()
            console.log('SUBMITTED LOGIN FORM')

            const form = jQuery(e.currentTarget)
            const formData = form.serialize()
            const formAction = form.attr('action')
            const inputs = form.find(':input')
            const submitButton = form.find(':submit')
            const container = form.parent()
            const alerts = container.find('.form-alerts')

            alerts.empty()
            inputs.prop('readonly', true)
            submitButton.prop('readonly', true)

            $.ajax({
                url: formAction,
                method: 'POST',
                // datatype: 'json',
                data: formData + '&ajax=1',
            })
                .always(() => {
                    inputs.prop('readonly', false)
                    submitButton.prop('readonly', false)
                })
                .done((response) => {
                    console.log('Login done', response)

                    if (response.success) {
                        if (response.data.refresh) {
                            location.reload(!0)
                        }
                        if (response.data.redirect) {
                            location.href = response.data.redirect
                        }
                        response.data.notice &&
                            alerts.hide().html(response.data.notice).fadeIn()

                        return
                    }

                    alerts.hide().html(response.data.errors).fadeIn()
                })
                .fail((response) => {
                    console.error(response)

                    if (response.responseText) {
                        console.error(response.responseText)
                    }

                    response.data?.errors &&
                        alerts.hide().html(response.data.errors).fadeIn()
                })
        })
    }
}
