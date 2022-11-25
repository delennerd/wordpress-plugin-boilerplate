/**
 * Some helper functions for api calls with fetch
 */

export class HttpHelper {
    static async sendData(url, method, data) {
        return await jQuery.ajax(url, {
            method: method,
            data: data,
            cache: false,
        })
        return await fetch(url, {
            method: method,
            body: data,
            mode: 'cors',
            cache: 'no-cache',
            credentials: 'same-origin',
            headers: {
                // 'Content-Type': 'application/json',
            },
            redirect: 'follow',
            referrerPolicy: 'no-referrer',
        })
    }

    /**
     *
     * @param {string} url
     * @param {object} data
     * @returns
     */
    static async get(url, data) {
        const formData = new URLSearchParams(data)

        const response = await this.sendData(url, 'get', data)
        // return response.json()
        return response
    }

    /**
     *
     * @param {string} url
     * @param {object} data
     * @returns
     */
    static async post(url, data) {
        const formData = new URLSearchParams(data)

        const response = await this.sendData(url, 'post', data)
        // return response.json()
        return response
    }
}
