import React, { useCallback, useEffect } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import PageHead from '../components/PageHead'
import TabsCustom from '../components/TabsCustom'
import InventoryTabs from '../components/Inventory/InventoryTabs';
import AdjustmentTabs from '../components/Inventory/AdjustmentTabs';
export default function Inventory() {
    return <DashboardLayout>
        <div>
            <PageHead title='Inventory'
                subtitle='Manage inventory'
            />
            <div className='container mt-3'>
                <TabsCustom
                    navs={[
                        { key: 'Inventory', label: 'Inventory' },
                        { key: 'Adjustments', label: 'Adjustments' }
                    ]}
                    contents={[
                        <div className='mt-3'>
                            <InventoryTabs/>
                        </div>,
                        <div className='mt-3'>
                            <AdjustmentTabs/>
                        </div>
                    ]}
                />
            </div>
        </div>
    </DashboardLayout>
}