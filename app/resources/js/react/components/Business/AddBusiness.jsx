import React from "react";
import SecondaryButton from "../UI/Buttons/SecondaryButton";
import SuccessButton from "../UI/Buttons/SuccessButton";
import { InputForm } from "../UI/Input/InputForm";
import { useI18n } from "../../../i18n/useI18n";

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
  const { t } = useI18n();
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
            <h5 className="modal-title fw-semibold theme-title-highlight">{t("Add company")}</h5>
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
                <label className="form-label theme-title">{t("Name")}</label>
                <InputForm
                  errorMessage={form.formErrors?.name}
                  value={form.formData?.name}
                  handleChange={form.handleChange}
                  name="name"
                  placeholder={t("Your company name")} />
              </div>

              <div className="mb-3">
                <label className="form-label theme-title">{t("Address")}</label>
                <InputForm
                  errorMessage={form.formErrors?.address}
                  value={form.formData?.address}
                  handleChange={form.handleChange}
                  name="address"
                  placeholder={t("Your company address")} />
              </div>
              <div className="mb-3">
                <label className="form-label theme-title">{t("Tax code")}</label>
                <InputForm
                  errorMessage={form.formErrors?.tax_code}
                  value={form.formData?.tax_code}
                  handleChange={form.handleChange}
                  name="tax_code"
                  placeholder={t("Your company tax code")} />
              </div>
              <div className="row">
                <div className="mb-3 col-6">
                  <label className="form-label theme-title">{t("Phone")}</label>
                  <InputForm
                    errorMessage={form.formErrors?.phone}
                    value={form.formData?.phone}
                    handleChange={form.handleChange}
                    name="phone"
                    placeholder={t("Your company contact phone")} />
                </div>
                <div className="mb-3 col-6">
                  <label className="form-label theme-title">{t("Email")}</label>
                  <InputForm
                    errorMessage={form.formErrors?.email}
                    value={form.formData?.email}
                    handleChange={form.handleChange}
                    name="email"
                    placeholder={t("Your company contact email")} />
                </div>
              </div>
              <div className="mb-3">
                <label className="form-label theme-title">{t("Bank name")}</label>
                <InputForm
                  errorMessage={form.formErrors?.bank_name}
                  value={form.formData?.bank_name}
                  handleChange={form.handleChange}
                  name="bank_name"
                  placeholder={t("Your company bank name")} />
              </div>
              <div className="row">
                <div className="mb-3 col-6">
                  <label className="form-label theme-title">{t("Bank account number")}</label>
                  <InputForm
                    errorMessage={form.formErrors?.bank_account_number}
                    value={form.formData?.bank_account_number}
                    handleChange={form.handleChange}
                    name="bank_account_number"
                    placeholder={t("Your company bank account number")} />
                </div>
                <div className="mb-3 col-6">
                  <label className="form-label theme-title">{t("Bank account name")}</label>
                  <InputForm
                    errorMessage={form.formErrors?.bank_account_name}
                    value={form.formData?.bank_account_name}
                    handleChange={form.handleChange}
                    name="bank_account_name"
                    placeholder={t("Your company bank account name")} />
                </div>
              </div>
            </form>
          </div>

          <div className="modal-footer border-secondary">
            <SecondaryButton label={t("Cancel")} onClick={onClose} />
            <SuccessButton onClick={onConfirm} label={t("Add new")} />
          </div>
        </div>
      </div>
    </div>
  );
}

