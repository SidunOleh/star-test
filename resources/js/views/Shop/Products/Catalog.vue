<template>
    <a-flex     
        class="catalog"
        :gap="20">
        <div class="filters">
            <a-typography-title :level="5">
                Categories
            </a-typography-title>
            <a-checkbox-group 
                v-if="categories.length"
                v-model:value="query.filters.categories" 
                :options="categoriesOptions"/>
            <a-skeleton v-else />
            <br><br>
            <a-typography-title :level="5">
                Price
            </a-typography-title>
            <a-slider 
                v-model:value="chosenRange" 
                range
                :min="priceRange[0]"
                :max="priceRange[1]"
                :tip-formatter="val => formatPrice(val)"
                @afterChange="query.filters.price = chosenRange"/>
        </div>
        <div class="products">
            <a-spin :spinning="loading">
                <template v-if="data.data?.length">
                    <a-row :gutter="[20,20]">
                        <a-col 
                            v-for="product in data.data ?? []"
                            :span="span">
                            <Product :data="product"/>
                        </a-col>
                    </a-row>
                    <br>
                    <div class="pag">
                        <a-pagination 
                            v-model:current="query.page" 
                            v-model:pageSize="query.perPage"
                            :total="totalPage"
                            :hideOnSinglePage="true"/>
                    </div>
                </template>
                <a-empty v-else/>
            </a-spin>
        </div>
    </a-flex>
</template>

<script>
import productsApi from '../../../api/shop/products'
import categoriesApi from '../../../api/shop/categories'
import { message, } from 'ant-design-vue'
import { formatPrice, } from '../../../helpers/helpers'
import Product from './Product.vue'

export default {
    components: {
        Product,
    },
    data() {
        return {
            data: {},
            query: {
                page: 1,
                perPage: 9,
                orderBy: 'created_at',
                order: 'DESC',
                filters: {
                    price: [],
                    categories: [],
                },
            },
            loading: false,
            categories: [],
            priceRange: [0, 1000000],
            chosenRange: [0, 1000000],
            span: 8,
        }  
    },
    computed: {
        categoriesOptions() {
            return this.categories.map(category => {
                return {
                    label: category.name,
                    value: category.id,
                }
            })
        },
        totalPage() {
            return Math.ceil(this.data.meta?.total / this.data.meta?.per_page)
        },
    },
    methods: {
        formatPrice,
        async fetchCategories() {
            try {
                this.categories = await categoriesApi.all()
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        async fetchPriceRange() {
            try {
                this.priceRange = await productsApi.getPriceRange()
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            }
        },
        async fetchProducts() {
            try {
                this.loading = true
                this.data = await productsApi.fetch(this.query)
            } catch (err) {
                message.error(err?.response?.data?.message ?? err.message)
            } finally {
                this.loading = false
            }
        },
        setColumns() {
            if (window.innerWidth < 768) {
                this.span = 24
            } else {
                this.span = 8
            }
        },
    },
    watch: {
        query: {
            handler() {
                this.fetchProducts()
            },
            deep: true,
        },
    },
    mounted() {
        this.fetchCategories()
        this.fetchPriceRange()
        this.fetchProducts()

        this.setColumns()
        window.addEventListener('resize', this.setColumns)
    }
}
</script>

<style scoped>
.catalog {
    min-height: calc(100vh - 135px)
}

.filters {
    width: 200px;
    padding: 10px;
    background-color: rgb(245 245 245);
    flex-shrink: 0;
}

.products {
    flex-grow: 1;
    padding: 10px;
}

.pag {
    display: flex;
    justify-content: center;
}

@media (max-width: 768px) {
    .catalog {
        flex-direction: column;
    }

    .filters {
        width: auto;
        flex-grow: 1;
    }
}
</style>