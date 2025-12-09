import React from "react";
import SecondaryButton from "../UI/Buttons/SecondaryButton";
import SuccessButton from "../UI/Buttons/SuccessButton";
import { InputForm } from "../UI/Input/InputForm";

export function AddBusiness({
  form = {
    formData: null,
    formErrors: null,
    formSetData: null,
    formSetErrors: null
  },
  onClose = null,
  onConfirm = null
}) {
  return (
    <div
      className={`modal fade show d-block`}
      tabIndex="-1"
      role="dialog"
      style={{ backgroundColor: "rgba(0,0,0,0.6)" }}
    >
      <div className="modal-dialog modal-dialog-centered modal-md" role="document">
        <div className="modal-content theme-bg theme-title border-0 rounded-3 shadow-lg">
          <div className="modal-header border-secondary">
            <h5 className="modal-title fw-semibold theme-title-highlight">Add company</h5>
            <button
              type="button"
              className="btn-close btn-close-white"
              aria-label="Close"
              onClick={onClose}
            ></button>
          </div>

          <div className="modal-body">
            <form>
              <div className="mb-3">
                <label className="form-label theme-title">Name</label>
                <InputForm
                  errorMessage={form.formErrors?.name}
                  value={form.formData?.name}
                  handleChange={form.handleChange}
                  name="name"
                  placeholder="Your company name" />
              </div>

              <div className="mb-3">
                <label className="form-label theme-title">Address</label>
                <InputForm
                  errorMessage={form.formErrors?.address}
                  value={form.formData?.address}
                  handleChange={form.handleChange}
                  name="address"
                  placeholder="Your company address" />
              </div>
              <div className="mb-3">
                <label className="form-label theme-title">Tax code</label>
                <InputForm
                  errorMessage={form.formErrors?.tax_code}
                  value={form.formData?.tax_code}
                  handleChange={form.handleChange}
                  name="tax_code"
                  placeholder="Your company tax code" />
              </div>
              <div className="row">
                <div className="mb-3 col-6">
                  <label className="form-label theme-title">Phone</label>
                  <InputForm
                    errorMessage={form.formErrors?.phone}
                    value={form.formData?.phone}
                    handleChange={form.handleChange}
                    name="phone"
                    placeholder="Your company contact phone" />
                </div>
                <div className="mb-3 col-6">
                  <label className="form-label theme-title">Email</label>
                  <InputForm
                    errorMessage={form.formErrors?.email}
                    value={form.formData?.email}
                    handleChange={form.handleChange}
                    name="email"
                    placeholder="Your company contact email" />
                </div>
              </div>
              <div className="mb-3">
                <label className="form-label theme-title">Bank name</label>
                <InputForm
                  errorMessage={form.formErrors?.bank_name}
                  value={form.formData?.bank_name}
                  handleChange={form.handleChange}
                  name="bank_name"
                  placeholder="Your company bank name" />
              </div>
              <div className="row">
                <div className="mb-3 col-6">
                  <label className="form-label theme-title">Bank account number</label>
                  <InputForm
                    errorMessage={form.formErrors?.bank_account_number}
                    value={form.formData?.bank_account_number}
                    handleChange={form.handleChange}
                    name="bank_account_number"
                    placeholder="Your company bank account number" />
                </div>
                <div className="mb-3 col-6">
                  <label className="form-label theme-title">Bank account name</label>
                  <InputForm
                    errorMessage={form.formErrors?.bank_account_name}
                    value={form.formData?.bank_account_name}
                    handleChange={form.handleChange}
                    name="bank_account_name"
                    placeholder="Your company bank account name" />
                </div>
              </div>
            </form>
          </div>

          <div className="modal-footer border-secondary">
            <SecondaryButton label="Cancel" onClick={onClose} />
            <SuccessButton onClick={onConfirm} label="Add new" />
          </div>
        </div>
      </div>
    </div>
  );
}
