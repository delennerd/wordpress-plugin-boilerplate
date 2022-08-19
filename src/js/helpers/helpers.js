export default class Helpers {
    constructor() {
        this.apiBaseUrl = `${pluginNameConfig.apiUrl}/riedl-catalog/v1`

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
}
