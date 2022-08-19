import Helpers from '../helpers/helpers'
import { getApiData, postApiData } from '../helpers/api-helper'

export default class Pagination extends Helpers {
    constructor() {
        super()
        // this.paginationWrapperClass = 'product-pagination';
        // this.paginationItemActiveClass = 'active';
        this.paginationWrapper = jQuery(`#${this.paginationWrapperId}`)
        this.productsList = jQuery(`#${this.productsListId}`)
        this.filterCounterButton = jQuery(
            `#${this.filterCounterButtonId}`
        ).find('span')

        // this.handlePaginationItems()

        this.handleFilterButton()
        this.handleResetFilterButton()
    }

    init() {
        const urlQueryParams = new URLSearchParams(window.location.search)
        this.loadProducts({ page: urlQueryParams.get('page') ?? 1 })
    }

    handlePaginationItems() {
        this.paginationWrapper.find('li > a.item-link').on('click', (e) => {
            e.preventDefault()

            const _clickedItem = jQuery(e.currentTarget)
            const pageNumber = _clickedItem.attr('data-page') ?? ''

            this.changeLocationParams({ page: pageNumber })

            const params = {
                page: pageNumber,
            }

            this.loadProducts(params)
        })
    }

    handleFilterButton() {
        jQuery(`#product-filter-search`).on('click', async (e) => {
            const helper = new Helpers()
            helper.removeLocationParam('category')

            await this.loadProducts()
        })
    }

    handleResetFilterButton() {
        const self = this
        const filterResetButtonId = 'product-filter-reset'

        jQuery(`#${filterResetButtonId}`).on('click', (e) => {
            const _clickedItem = jQuery(e.currentTarget)

            this.resetFilters()
        })
    }

    async resetFilters() {
        const filterWrapper = jQuery('.product-filter-wrapper')
        const filterItems = filterWrapper.find('.product-filter')
        const inputs = filterItems.find('input')

        inputs.each((index, item) => {
            const _item = jQuery(item)
            _item.prop('checked', false)
        })

        const helper = new Helpers()
        helper.removeLocationParam('category')

        await this.loadProducts()
    }

    async loadProducts(params = { page: 1 }) {
        const ajaxData = {}
        ajaxData.page = params.page

        this.hideCatalog()

        const searchQuery = filter.getSearchQuery()
        if (searchQuery != undefined) {
            ajaxData.search = searchQuery
        }

        // const filterCategories = filter.getFilterValuesCategory()
        const filterCategories = filter.getCategoryQuery()

        if (filterCategories) {
            // console.log("CATEGORIES", filterCategories)
            ajaxData.categories = JSON.stringify(filterCategories)

            console.log(ajaxData.categories)
        }

        const dataQuery = Object.keys(ajaxData)
            .map((key) => `${key}=${ajaxData[key]}`)
            .join('&')

        console.log('loadProducts() => dataQuery', dataQuery)

        try {
            const paginationResponse = await jQuery.ajax({
                url: `${this.apiBaseUrl}/products`,
                method: 'GET',
                datatype: 'json',
                data: ajaxData,
                async: true,
                cache: false,
            })

            if (paginationResponse.html != undefined) {
                this.productsList.html(paginationResponse.html)
                this.paginationWrapper.html(paginationResponse.pagination)
                this.filterCounterButton.text(paginationResponse.productsCount)

                if (!paginationResponse.productsFound) {
                    this.productsList.addClass('products--no-grid')
                }

                this.showCatalog()
                this.handlePaginationItems()

                console.log(paginationResponse)
                return
            }

            this.productsList.html('There was an error')
        } catch (e) {
            // console.warn(e)
            this.productsList.html(
                `There was an error loading the products. Please refresh the page.`
            )

            this.showCatalog()
        }
    }
}
