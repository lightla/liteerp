import React, { useCallback, useEffect, useMemo, useState } from 'react'
import FormStep from '../FormStep'
import { useNavigate, useSearchParams } from 'react-router-dom';
import { usePopup } from '../popups/PopupContext';
import { useForm } from '../../libraries/handleInput';
import PrimaryButton from '../UI/Buttons/PrimaryButton'
import SecondaryButton from '../UI/Buttons/SecondaryButton';
import PurchaseService from '../../services/PurchaseService';
import PurchaseInformation from './EditPurchase/PurchaseInformation';
import AddProduct from './AddProduct';
import { isoToDateTime } from '../../libraries/common';
import RequestContent from './EditPurchase/RequestContent';
import ApproveContent from './EditPurchase/ApproveContent';
import ApprovedContent from './EditPurchase/ApprovedContent';
import DangerButton from '../UI/Buttons/DangerButton';
import CancelledContent from './EditPurchase/CancelledContent';
import PageHead from '../PageHead'
import { PopupLayout } from '../../layouts/PopupLayout';
import TextArea from '../UI/Input/Textarea';
import { useDispatch, useSelector } from 'react-redux';
import { setPurchaseDetail } from '../../redux/purchase/detailSlice';
import BootstrapAlert from '../BootstrapAlert'
export default function EditPurchase() {
    const dispatch = useDispatch();
    const [showCancel, setShowCancel] = useState(false)
    const [searchParams] = useSearchParams();
    const navigate = useNavigate();
    const { openPopup } = usePopup();
    const form = useForm();
    const detail = useSelector((state) => state.purchasedetail.data);
    const [currentStep, setCurrentStep] = useState(1);
    const getPurchaseDetail = useCallback(() => {
        PurchaseService.show(searchParams.get('id'))
            .then((resp) => {
                form.setFormData(resp.message)
                dispatch(setPurchaseDetail(resp.message))
            })
            .catch((error) => {
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message,
                        onCancel: () => {
                            navigate('/purchases')
                        }
                    })
                }
            })
    }, []);
    const update = useCallback((status = 'draft', callback = null) => {
        form.setLoading(true)
        PurchaseService.update({
            ...form.formData,
            id: searchParams.get('id'),
            expected_date: isoToDateTime(form.formData?.expected_date),
            purchase_date: isoToDateTime(form.formData?.purchase_date),
            status: status
        })
            .then((resp) => {
                openPopup({
                    type: 'success',
                    message: 'You has been updated',
                    onCancel: callback ?? null
                });
                getPurchaseDetail();
                form.setLoading(false)
            })
            .catch((error) => {
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
                if (error.response.data?.errors) {
                    form.setFormErrors(error.response.data?.errors)
                }
                form.setLoading(false)
            })
    }, [form.formData]);
    const confirmUpdateToRequest = () => {
        openPopup({
            type: 'warning',
            message: 'Do you wanna send requested to approve',
            onConfirm: () => {
                update('requested')
            }
        })
    }
    const confirmUpdateToApprove = () => {
        openPopup({
            type: 'warning',
            message: 'Do you wanna change to approve',
            onConfirm: () => {
                update('approved')
            }
        })
    }
    const confirmUpdateToCancelled = () => {
        openPopup({
            type: 'warning',
            message: 'Do you wanna change to cancelled',
            onConfirm: () => {
                //update('cancelled')
                setShowCancel(true)
            }
        })
    }
    const nextStep = () => {
        if (currentStep === 2) {
            return;
        }
        switch (currentStep) {
            case 0:
                if (JSON.stringify(detail) !== JSON.stringify(form.formData)) {
                    openPopup({
                        cancelText: 'No change',
                        type: 'warning',
                        message: 'You just change data, do you wanna save change?',
                        onConfirm: () => {
                            update(form.formData?.status ?? 'draft', () => {
                                setCurrentStep((pre) => pre + 1)
                            })
                        },
                        onCancel: () => {
                            setCurrentStep((pre) => pre + 1);
                        }
                    })
                } else {
                    setCurrentStep((pre) => pre + 1);
                }
                break;
            case 1:
                setCurrentStep((pre) => pre + 1);
                break;
        }
    }
    const preStep = () => {
        if (currentStep === 0) {
            return;
        }
        setCurrentStep((pre) => pre - 1);
    }
    const view = useCallback(() => {
        PurchaseService.view()
            .then((resp) => {
                form.setHookRender(resp.message.form)
            })
            .catch((error) => {
                if (error.response.data?.message) {
                    openPopup({
                        type: 'error',
                        message: error.response.data?.message
                    })
                }
            });
    }, []);
    useEffect(() => {
        getPurchaseDetail();
        view();
    }, []);
    return <div>
        <PageHead
            containerClass="mx-4"
            title='Update purchase'
            subtitle='Update purchase information'
        />

        {detail?.status === 'cancelled' ? <div className='px-4 mt-3'>
            <BootstrapAlert type='danger' title='Cancelled' message={detail?.reason ?? 'No reason'} />
        </div> : null}

        <div className='mx-4 mt-3'>
            <FormStep list={[
                "Purchase information",
                "Add Products",
                "Request or Approve"
            ]} active={currentStep} />
            <div className='theme-card p-4 shadow rounded-4'>
                {form && detail ? <div><div className={currentStep === 0 ? 'show' : 'hidden'}>
                    <PurchaseInformation form={form} />
                </div>
                    <div className={currentStep === 1 ? 'show' : 'hidden'}>
                        <AddProduct />
                    </div>
                    <div className={currentStep === 2 ? 'show' : 'hidden'}>
                        {detail?.status === 'draft' ? <RequestContent /> : null}
                        {detail?.status === 'requested' ? <ApproveContent /> : null}
                        {detail?.status === 'approved' ? <ApprovedContent /> : null}
                        {detail?.status === 'cancelled' ? <CancelledContent /> : null}
                    </div>
                </div> : null}
            </div>
            <div className="row">
                <div className="col-2">
                    <SecondaryButton onClick={preStep} label='Back' />
                </div>
                <div className="col-4 ms-auto text-end">
                    <div className='row'>
                        <div className='col-6'>
                            {detail?.status !== 'cancelled' ? <DangerButton
                                loading={form.loading}
                                onClick={confirmUpdateToCancelled}
                                label={'Take Cancelled'} /> : null}

                        </div>
                        <div className='col-6'>
                            {currentStep <= 1
                                ? <PrimaryButton loading={form.loading} onClick={nextStep} label='Next' />
                                : null}
                            {currentStep === 2 && detail?.status === 'draft'
                                ? <PrimaryButton loading={form.loading} onClick={confirmUpdateToRequest} label={'Send To Request'} /> : null}
                            {currentStep === 2 && detail?.status === 'requested'
                                ? <PrimaryButton loading={form.loading} onClick={confirmUpdateToApprove} label={'Take Approved'} /> : null}
                        </div>
                    </div>

                </div>
            </div>


        </div>
        {showCancel ? <PopupLayout
            loading={form.loading}
            onConfirm={() => {
                update('cancelled');
                setShowCancel(false)
            }}
            onClose={() => setShowCancel(false)}
            confirmText='Submit cancel'
            title='Cancel reason'>
            <label>Reason</label>
            <TextArea
                name='reason'
                errorMessage={form.formErrors?.reason}
                handleChange={form.handleChange}
                value={form.formData?.reason}
                placeholder='Reason cancel purchase, maximum 250 characters'
            />
        </PopupLayout> : null}

    </div>
}