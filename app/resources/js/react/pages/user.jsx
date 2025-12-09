import React, { useCallback, useEffect, useState } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import PageHead from '../components/PageHead'
import CommonDataTable from '../components/CommonDataTable'
import UserService from '../services/UserService'
import useTable from '../libraries/handleTable'
import { useForm } from '../libraries/handleInput'
import { PopupLayout } from '../layouts/PopupLayout'
import { InputForm } from '../components/UI/Input/InputForm'
import { usePopup } from '../components/popups/PopupContext'
import { Select } from '../components/UI/Input/Select'
export default function User(){
    const {openPopup} = usePopup()
    const table = useTable();
    const form = useForm();
    const [showForm,setShowForm] = useState(false);
    const getUsers = useCallback(() => {
        table.setLoading(true)
        UserService.list({
            keywords: '',
            page: 0
        }).then((resp) => {
             table.setLoading(false)
            table.setData(resp.message.data);
            table.setLinks(resp.message.links);
        }).catch((error) => {

        })
    },[]);
    const handleEdit = (row) => {
        {/* if(row.role === 'admin') {
            return openPopup({
                type: 'warning',
                message: 'You can not modifine admin account'
            })
        } */}
        form.setIsEdit(true);
        form.setFormData(row);
        setShowForm(true);
    }
    const submit = useCallback(()=>{
        form.setFormErrors(null);
        form.setLoading(true);
        UserService.add(form.formData)
        .then((resp) => {
            form.setFormData(null)
            openPopup({
                type: 'success',
                message: 'You has been added'
            })
            setShowForm(false);
            getUsers();
            form.setLoading(false);
        })  
        .catch((error) => {
            if(error.response?.data?.errors) {
                form.setFormErrors(error.response?.data?.errors)
            }
            if(error.response?.data?.message) {
                openPopup({
                    type: 'error',
                    message: error.response?.data?.message
                })
            }
            form.setLoading(false);
        })
    },[form.formData])
    const update = useCallback(()=>{
        form.setFormErrors(null);
        form.setLoading(true);
        UserService.update(form.formData)
        .then((resp) => {
            form.setFormData(null)
            openPopup({
                type: 'success',
                message: 'You has been added'
            })
            setShowForm(false);
            getUsers();
            form.setLoading(false);
        })  
        .catch((error) => {
            if(error.response?.data?.errors) {
                form.setFormErrors(error.response?.data?.errors)
            }
            if(error.response?.data?.message) {
                openPopup({
                    type: 'error',
                    message: error.response?.data?.message
                })
            }
            form.setLoading(false);
        })
    },[form.formData])
    useEffect(() => {
        getUsers();
    },[])
    return <DashboardLayout>
        <div>
           <PageHead
           title='Employee'
           subtitle={`Anyone can not create account, employee should register new account and manage it. This feature only add user into business with role`}
           />
           <div className='container mt-3'>
            <CommonDataTable
            loading={table.loading}
            add={() => {
                setShowForm(true)
            }}
            columns={[
                {key: 'id',label: 'ID'},
                {key: 'avatar',label: 'Avatar',render:(avatar) => {
                    return <img 
                    width={50}
                    height={50}
                    src={avatar ?? '/assets/icons/avatar-default.png'} alt=''/>
                }},
                {key: 'bio',label: 'Bio',render:(bio) => {
                    return <span>
                        {bio?.toString().length >= 20 
                        ? bio?.toString().substring(0,20) + '...' : ''}
                    </span>
                }},
                {key: 'phone',label: 'Phone'},
                {key: 'email',label: 'Email'},
                {key: 'name',label: 'Name'},
                {key: 'role',label: 'role',render:(role) => {
                    return <span
                    className={'badge text-uppercase ' 
                        + (role === 'admin' ? 'bg-success' : 'bg-warning text-dark')}
                    >{role}</span>
                }},
                {key: 'last_seen',label: 'Last seen'},
            ]}
            data={table.data}
            links={table.links}
            onDelete={(row) => {}}
            onEdit={handleEdit}
            />
           </div>
           <div>
            {showForm ? <PopupLayout 
            loading={form.loading}
            onConfirm={ form.isEdit ? update : submit}
            onClose={() => {
                setShowForm(false);
                form.setIsEdit(false)
            }}
            title={!form.isEdit ? 'Add staff' : 'Update staff'}>
                <div>
                    <div>
                        <label>Email</label>
                        <InputForm
                        name='email'
                        errorMessage={form.formErrors?.email}
                        value={form.formData?.email}
                        handleChange={form.handleChange}
                        />
                    </div>
                    <div>
                        <label>Role</label>
                        <Select
                        name='role'
                        errorMessage={form.formErrors?.role}
                        value={form.formData?.role}
                        handleChange={form.handleChange}
                        options={[
                            {value: 'manager',label: 'Manager'},
                            {value: 'seller',label: 'Seller'},
                            {value: 'accountanter',label: 'Accountanter'},
                            {value: 'warehouseman',label: 'Warehouseman'},
                            {value: 'purchaser',label: 'Purchaser'},
                            {value: 'admin',label: 'Admin'}
                        ]}
                        />
                    </div>
                </div>
            </PopupLayout> : null}
           </div>
        </div>
    </DashboardLayout>
}