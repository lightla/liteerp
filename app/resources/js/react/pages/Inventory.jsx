import React from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import PageHead from '../components/PageHead'
import TabsCustom from '../components/TabsCustom'
import InventoryTabs from '../components/Inventory/InventoryTabs'
import AdjustmentTabs from '../components/Inventory/AdjustmentTabs'
import { useI18n } from '../../i18n/useI18n'

export default function Inventory() {
    const { t } = useI18n()

    return (
        <DashboardLayout>
            <div>
                <PageHead
                    title={t('Inventory')}
                    subtitle={t('Manage inventory')}
                />

                <div className="container mt-3">
                    <TabsCustom
                        navs={[
                            {
                                key: 'inventory',
                                label: t('Inventory'),
                            },
                            {
                                key: 'adjustments',
                                label: t('Adjustments'),
                            },
                        ]}
                        contents={[
                            <div className="mt-3" key="inventory">
                                <InventoryTabs />
                            </div>,
                            <div className="mt-3" key="adjustments">
                                <AdjustmentTabs />
                            </div>,
                        ]}
                    />
                </div>
            </div>
        </DashboardLayout>
    )
}
