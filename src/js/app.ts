/**
 * @author Pascal Lehnert <mail@delennerd.de>
 */

import { AuthForm } from './components/forms/AuthForm'

// const jQuery = window.jQuery

class PluginName {
    constructor() {
        // const example = new Example()
        // example.init()

        new AuthForm()
    }
}

jQuery(function () {
    new PluginName()
})
