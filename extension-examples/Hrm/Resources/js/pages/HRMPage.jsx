import React, { useState } from 'react';
import TimeAttendance from '../components/TimeAttendance';
import EndOfDayReportForm from '../components/EndOfDayReportForm';
import MonthlyAttendanceSummary from '../components/MonthlyAttendanceSummary';
import LeaveApprovalList from '../components/LeaveApprovalList';
import DashboardLayout from '@layouts/DashboardLayout'
import PageHead from '@components/PageHead'
import TabsCustom from '@components/TabsCustom'
import {useI18n} from '@i18n/useI18n'
const HRMPage = () => {
    const {t} = useI18n()

    return (
        <DashboardLayout>
            <div className="">
                <PageHead title={t('hrm.title')} subtitle={t('hrm.desc')}/>
                <div className='mt-3 container'>
                    <TabsCustom
                navs={[
                    {key: 'time-attendance',label: t('hrm.attendance.title')},
                    {key: 'end-of-day',label: t('hrm.report.title')},
                    {key: 'monthly-summary', label: t('hrm.export.title')},
                    {key: 'leave-approval', label: t('hrm.leave.title')}
                ]}
                contents={[
                    <div>
                        <TimeAttendance/>
                    </div>,
                    <div>
                        <EndOfDayReportForm/>
                    </div>,
                    <div>
                        <MonthlyAttendanceSummary/>
                    </div>,
                    <div>
                        <LeaveApprovalList/>
                    </div>
                ]}
                />
                </div>
            </div>
        </DashboardLayout>

    );
};

export default HRMPage;