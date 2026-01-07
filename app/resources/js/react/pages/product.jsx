import React from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import TabsCommon from '../components/TabsCustom'
import Category from '../components/Product/Category'
import ListProducts from '../components/Product/ListProducts'
import PriceList from '../components/Product/PriceList'
import PageHead from '../components/PageHead'
import { useI18n } from '../../i18n/useI18n'

export default function Product() {
    const { t } = useI18n()

    return (
        <DashboardLayout>
            <div>
                <PageHead
                    title={t('Products')}
                    subtitle={t('Manager product by warehouse, category')}
                />

                <div className="container mt-3">
                    <TabsCommon
                        navs={[
                            {
                                key: 'products',
                                label: t('Products'),
                            },
                            {
                                key: 'category',
                                label: t('Category'),
                            },
                            {
                                key: 'price',
                                label: t('Price list'),
                            },
                        ]}
                        contents={[
                            <div key="products">
                                <ListProducts />
                            </div>,
                            <div key="category">
                                <Category />
                            </div>,
                            <div key="price">
                                <PriceList />
                            </div>,
                        ]}
                    />
                </div>
            </div>
        </DashboardLayout>
    )
}
