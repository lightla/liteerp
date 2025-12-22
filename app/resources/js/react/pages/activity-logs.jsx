import React, { useCallback, useEffect } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import PageHead from '../components/PageHead'
import CommonDataTable from '../components/CommonDataTable'
import ActivityLogService from '../services/ActivityLogService';
import useTable from '../libraries/handleTable';
import { isoToDateTime } from '../libraries/common';
import StatusBadge from '../components/StatusBadge'
export default function ActivityLogs(){
    const table = useTable();
    const getLogs = useCallback((page = 0) => {
        table.setLoading(true)
        ActivityLogService.list({
            page: page
        })
        .then((resp) => {
            table.setLoading(false)
            table.setData(resp.message.data);
            table.setLinks(resp.message.links)
        })
        .catch((error) => {

        })
    },[]);
    useEffect(() => {
        getLogs();
    },[])
    return <DashboardLayout>
        <div>
            <PageHead
            title='Activity logs'
            subtitle='Manage all logs on system by action users'
            />
            <div className='container mt-3'>
                <CommonDataTable
                movePage={getLogs}
                loading={table.loading}
                data={table.data}
                links={table.links}
                columns={[
                    {key: 'id',label: "ID"},
                    {key: 'action', label: 'Action',render:(action) => {
                        return <StatusBadge status={action}/>
                    }},
                    {key: 'description', label: 'Description'},
                    {key: 'entity_type', label: 'Type'},
                    {key: 'entity_id', label: 'Entity ID'},
                    {key: 'created_at', label: 'Created at',render: (time) => {
                        return <span>{isoToDateTime(time)}</span>
                    }}
                ]}
                />
            </div>
        </div>
    </DashboardLayout>
}