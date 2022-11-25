export default class Helpers {
    constructor() {
        this.apiBaseUrl = `${pluginNameConfig.apiUrl}/api-endpoint/v1`

        this.paginationWrapperId = 'product-pagination'
        this.paginationWrapperClass = 'product-pagination'
        this.paginationItemActiveClass = 'active'

        this.loaderId = 'my-loader'
    }

    /**
     *
     * @param {string} param
     * @returns
     */
    getLocationParams(param) {
        const currentUrl = new URL(window.location.href)
        return currentUrl.searchParams.get(param)
    }

    /**
     *
     * @param {object} params (key: value)
     */
    changeLocationParams(params = {}) {
        const currentUrl = new URL(window.location.href)

        Object.entries(params).forEach((entry) => {
            const [key, value] = entry
            currentUrl.searchParams.set(key, value)

            if (key === '') {
                currentUrl.searchParams.delete(key)
            }
        })

        window.history.replaceState(null, null, currentUrl)
    }

    removeLocationParam(param) {
        const currentUrl = new URL(window.location.href)
        currentUrl.searchParams.delete(param)

        window.history.replaceState(null, null, currentUrl)
    }

    hideElement() {
        // this.paginationWrapper = jQuery(`#${this.paginationWrapperId}`)

        // this.paginationWrapper.fadeOut(250)
        this.loader.show()
    }

    showElement() {
        // this.paginationWrapper = jQuery(`#${this.paginationWrapperId}`)

        // this.paginationWrapper.fadeIn(250)
        this.loader.hide()
    }

    static getViewportWidth() {
        var viewportwidth
        if (typeof window.innerWidth != 'undefined') {
            viewportwidth = window.innerWidth
        } else if (
            typeof document.documentElement != 'undefined' &&
            typeof document.documentElement.clientWidth != 'undefined' &&
            document.documentElement.clientWidth != 0
        ) {
            viewportwidth = document.documentElement.clientWidth
        } else {
            viewportwidth = document.getElementsByTagName('body')[0].clientWidth
        }
        return viewportwidth
    }

    static getViewportHeight() {
        var viewportHeight
        if (typeof window.innerHeight != 'undefined') {
            viewportHeight = window.innerHeight
        } else if (
            typeof document.documentElement != 'undefined' &&
            typeof document.documentElement.clientHeight != 'undefined' &&
            document.documentElement.clientHeight != 0
        ) {
            viewportHeight = document.documentElement.clientHeight
        } else {
            viewportHeight =
                document.getElementsByTagName('body')[0].clientHeight
        }
        return viewportHeight
    }
}
