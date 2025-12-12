import React, { useCallback, useEffect, useMemo, useState } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import CommonDataTable from '../components/CommonDataTable';
import { PopupLayout } from '../layouts/PopupLayout';
import { InputForm } from '../components/UI/Input/InputForm';
import WarehouseService from '../services/WarehouseService';
import { Select } from '../components/UI/Input/Select';
import { usePopup } from '../components/popups/PopupContext';
import SearchInput from '../components/UI/Input/SearchInput'
import { useForm } from '../libraries/handleInput';
import useTable from '../libraries/handleTable';
import PageHead from '../components/PageHead';
export default function Warehouse() {
  const { openPopup } = usePopup();
  const table = useTable();
  const form = useForm();
  const search = useForm(null);
  const [showPopup, setShowPopup] = useState(false);
  const columns = [
    { label: "ID", key: "id" },
    { label: "Name", key: "name" },
    { label: "Address", key: "address" },

    {
      label: "Products",
      key: "product_count",
      render: (value) => {
        return <span>{value}</span>;
      },
    },

    {
      label: "Status",
      key: "active",
      render: (value) => (
        <span
          className={`badge rounded-pill px-3 py-2 ${value === 1 ? "bg-success bg-opacity-75" : "bg-secondary"
            }`}
        >
          {value === 1 ? "Active" : "Inactive"}
        </span>
      ),
    },
  ];
  const getList = useCallback((page = 0) => {
    table.setLoading(true);
    WarehouseService.list({
      active: search.formData?.active ?? '',
      keywords: search.formData?.keywords ?? '',
      page: page
    })
      .then((resp) => {
        table.setData(resp.message.data);
        table.setLinks(resp.message.links);
        table.setLoading(false);
      })
      .catch((error) => {
        if (error.response.data?.errors) {

        }
      })
  }, [search.formData]);
  useEffect(() => {
    getList();
  }, [search.formData?.active]);
  const submit = useCallback(() => {
    form.setLoading(true)
    form.setFormErrors(null);
    WarehouseService.add(form.formData)
      .then((resp) => {
        getList();
        openPopup({
          type: 'success',
          message: 'You has been created'
        })
        setShowPopup();
        form.setFormData(null)
        form.setLoading(false)
      })
      .catch((error) => {
        if (error.response.data?.errors) {
          form.setFormErrors(error.response.data?.errors)
        }
        form.setLoading(false)
      })
  }, [form]);
  const edit = useCallback(() => {
    form.setFormErrors(null);
    form.setLoading(true)
    WarehouseService.update(form.formData)
      .then((resp) => {
        getList();
        openPopup({
          type: 'success',
          message: 'You has been updated'
        })
        setShowPopup();
        form.setLoading(false)
      })
      .catch((error) => {
        if (error.response.data?.errors) {
          form.setFormErrors(error.response.data?.errors)
        }
        if (error.response.data?.message) {
          openPopup({
            type: 'error',
            message: error.response.data?.message
          })
        }
        form.setLoading(false)
      })
  }, [form, table]);
  const destroy = useCallback((row) => {
    WarehouseService.delete(row)
      .then((resp) => {
        getList();
        openPopup({
          type: 'success',
          message: 'You has been deleted'
        })
      })
      .catch((error) => {
        if (error.response.data?.message) {
          openPopup({
            type: 'error',
            message: error.response.data?.message
          })
        }
      })
  }, []);
  const handleDelete = useCallback((row) => {
    openPopup({
      type: 'warning',
      message: 'Are you sure to delete?',
      onConfirm: () => {
        destroy(row)
      }
    })
  }, []);
  return <DashboardLayout>
    <div>
      <PageHead
        containerClass='mx-4'
        title='Warehouse'
        subtitle='Manager warehouse, To better good you 
        can use category product as areas on the warehouse for easy.'
      />
      <div className="m-4">
        <div>
          <CommonDataTable
            add={() => {
              setShowPopup(true);
              form.setIsEdit(false);
            }}
            loading={table.loading}
            filter={<div className=''>
              <div className='d-flex'>
                <div className='col-6'>
                  <label>Status</label>
                  <Select name='active' value={search.formData?.active ?? ''}
                    handleChange={search.handleChange} options={[
                      { value: 0, label: 'Inactive' },
                      { value: 1, label: 'Active' }
                    ]} />
                </div>
                <div className='col-6 mx-2'>
                  <label>Search</label>
                  <SearchInput
                    name='keywords'
                    submit={getList}
                    placeholder='Search by name'
                    value={search.formData?.keywords}
                    handleChange={search.handleChange} />
                </div>
              </div>
            </div>}
            movePage={getList}
            columns={columns}
            data={table?.data}
            links={table?.links}
            onEdit={(row) => {
              setShowPopup(true);
              form.setFormData(row);
              form.setIsEdit(true);
            }}
            onDelete={handleDelete}
          />
        </div>

      </div>
      {showPopup ? <PopupLayout
        loading={form.loading}
        confirmText="Save"
        title={!form.isEdit ? "New warehouse" : "Update warehouse"}
        onClose={() => {
          setShowPopup(false);
          form.setIsEdit(false);
        }}
        onConfirm={!form.isEdit ? submit : edit}>
        <div>
          <div className='form-group'>
            <label>Name</label>
            <InputForm errorMessage={form.formErrors?.name} name="name"
              value={form.formData?.name} handleChange={form.handleChange} type='text' placeholder='Name warehouse' />
          </div>
          <div className='form-group mt-3'>
            <label>Address</label>
            <InputForm errorMessage={form.formErrors?.address} name="address"
              value={form.formData?.address} handleChange={form.handleChange} type='text' placeholder='Address of warehouse' />
          </div>
          <div className='form-group mt-3 text-left'>
            <label className=''>Active</label>

            <div className='d-flex'>
              <InputForm
                width={10}
                errorMessage={form.formErrors?.active} name="active" className='input-checkbox'
                value={form.formData?.active} handleChange={form.handleChange}
                type="checkbox" />
              <span className='mx-2'>If you don't active then warehouse will status not working
                and you can not move products to this warehouse</span>
            </div>
          </div>

        </div>
      </PopupLayout> : null}
    </div>
  </DashboardLayout>
}