export class PasswordField {
    constructor() {
        this.togglePasswordField()
    }

    togglePasswordField() {
        const $passwordToggle = $('.password-toggle')

        if ($passwordToggle.length === 0) return

        $passwordToggle.on('click', function () {
            $(this)
                .parent()
                .find('.password-toggle')
                .attr('data-hidden', 'false')
            $(this).attr('data-hidden', 'true')

            if (
                $(this)
                    .parent()
                    .find('.password-toggle--show')
                    .attr('data-hidden') === 'false'
            ) {
                $(this).parent().find('input').attr('type', 'text')
            } else {
                $(this).parent().find('input').attr('type', 'password')
            }
        })
    }
}
