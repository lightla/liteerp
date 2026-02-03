import React, { useEffect, useState } from "react";
import PrimaryButton from '@components/UI/Buttons/PrimaryButton'
import { Select } from '@components/UI/Input/Select'
import { useForm } from '@libraries/handleInput'
import { InputForm } from '@components/UI/Input/InputForm'
import TextArea from '@components/UI/Input/Textarea'
import smtpService from "../services/smtpService";
import { usePopup } from '@components/popups/PopupContext'

const Home = () => {
    const form = useForm();
    const { openPopup } = usePopup();
    const saveSmtp = () => {
        form.setLoading(true)
        form.setFormErrors(null)
        smtpService.save(form.formData)
            .then((resp) => {
                openPopup({
                    message: 'You has been saved',
                    type: 'success'
                })
                form.setLoading(false)
            })
            .catch((error) => {
                if (error.response.data?.errors) {
                    form.setFormErrors(error.response.data?.errors)
                }
                if (error.response.data?.message) {
                    openPopup({
                        message: error.response.data?.message,
                        type: 'error'
                    })
                }
                form.setLoading(false)
            })
    };

    const sendTestMail = () => {
        form.setLoading(true)
        form.setFormErrors(null)
        smtpService.send(form.formData)
            .then((resp) => {
                openPopup({
                    message: 'You has been saved',
                    type: 'success'
                })
                form.setLoading(false)
            })
            .catch((error) => {
                if (error.response.data?.errors) {
                    form.setFormErrors(error.response.data?.errors)
                }
                if (error.response.data?.message) {
                    openPopup({
                        message: error.response.data?.message,
                        type: 'error'
                    })
                }
                form.setLoading(false)
            })
    };

    useEffect(() => {
        form.setLoading(true)
        smtpService.show()
            .then((resp) => {
                form.setFormData(resp.message)
                form.setLoading(false)
            })
            .catch((error) => {
                form.setLoading(false)
            })
    }, []);

    return (
        <div className="container py-4" style={{ maxWidth: 720 }}>
            <div className="card">
                <div className="card-header fw-bold">
                    Mail Settings
                </div>

                <div className="card-body">
                    {/* TABS */}
                    <ul className="nav nav-tabs mb-3" role="tablist">
                        <li className="nav-item">
                            <button
                                className="nav-link active"
                                data-bs-toggle="tab"
                                data-bs-target="#smtp-setting"
                                type="button"
                            >
                                SMTP Settings
                            </button>
                        </li>
                        <li className="nav-item">
                            <button
                                className="nav-link"
                                data-bs-toggle="tab"
                                data-bs-target="#smtp-test"
                                type="button"
                            >
                                Send Test Mail
                            </button>
                        </li>
                    </ul>

                    {/* TAB CONTENT */}
                    <div className="tab-content">
                        {/* SETTINGS TAB */}
                        <div className="tab-pane fade show active" id="smtp-setting">
                            <div className="mb-3">
                                <label className="form-label">Host</label>
                                <InputForm name="host"
                                    value={form.formData?.host}
                                    handleChange={form.handleChange} errorMessage={form.formErrors?.host} />
                            </div>

                            <div className="row">
                                <div className="col-md-6 mb-3">
                                    <label className="form-label">Port</label>
                                    <InputForm
                                        value={form.formData?.port}
                                        name="port" handleChange={form.handleChange} errorMessage={form.formErrors?.port} />
                                </div>

                                <div className="col-md-6 mb-3">
                                    <label className="form-label">Encryption</label>
                                    <Select
                                        value={form.formData?.encryption}
                                        name="encryption" handleChange={form.handleChange}
                                        errorMessage={form.formErrors?.encryption}
                                        options={[
                                            { label: 'tls', value: 'tls' },
                                            { label: 'ssl', value: 'ssl' }
                                        ]}
                                    />
                                </div>
                            </div>

                            <div className="mb-3">
                                <label className="form-label">Username</label>
                                <InputForm name="username"
                                    value={form.formData?.username}
                                    handleChange={form.handleChange}
                                    errorMessage={form.formErrors?.username} />
                            </div>

                            <div className="mb-3">
                                <label className="form-label">Password</label>
                                <InputForm
                                    type="password"
                                    name="password"
                                    value={form.formData?.password}
                                    handleChange={form.handleChange}
                                    errorMessage={form.formErrors?.password} />
                            </div>

                            <div className="row">
                                <div className="col-md-6 mb-3">
                                    <label className="form-label">From Email</label>
                                    <InputForm name="from_email"
                                        value={form.formData?.from_email}
                                        handleChange={form.handleChange}
                                        errorMessage={form.formErrors?.from_email} />
                                </div>

                                <div className="col-md-6 mb-3">
                                    <label className="form-label">From Name</label>
                                    <InputForm name="from_name"
                                        value={form.formData?.from_name}
                                        handleChange={form.handleChange}
                                        errorMessage={form.formErrors?.from_name} />
                                </div>
                            </div>

                            <div className="text-end">
                                <PrimaryButton loading={form.loading} onClick={saveSmtp} label="Save setting" />
                            </div>
                        </div>

                        {/* TEST TAB */}
                        <div className="tab-pane fade" id="smtp-test">
                            <div className="mb-3">
                                <label className="form-label">To</label>
                                <InputForm name="to"
                                    value={form.formData?.to}
                                    handleChange={form.handleChange}
                                    errorMessage={form.formErrors?.to} />
                            </div>

                            <div className="mb-3">
                                <label className="form-label">Subject</label>
                                <InputForm name="subject"
                                    value={form.formData?.subject}
                                    handleChange={form.handleChange}
                                    errorMessage={form.formErrors?.subject} />
                            </div>

                            <div className="mb-3">
                                <label className="form-label">Message</label>
                                <TextArea name="message"
                                    value={form.formData?.message}
                                    handleChange={form.handleChange}
                                    errorMessage={form.formErrors?.message} />
                            </div>

                            <div className="text-end">
                                <PrimaryButton loading={form.loading} onClick={sendTestMail} label="Send test" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Home;
