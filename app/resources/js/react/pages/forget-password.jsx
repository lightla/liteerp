import React, { useState, useEffect, useCallback } from "react";
import GradientButton from "../components/UI/Buttons/GradientButton";
import AuthencationService from "../services/AuthencationService";
import AuthLayout from "../layouts/AuthLayout";
import { Link, useNavigate } from "react-router-dom";
import { usePopup } from '../components/popups/PopupContext'
import { useForm } from "../libraries/handleInput";
import { InputForm } from "../components/UI/Input/InputForm";
export default function ForgetPassword() {
  const { openPopup } = usePopup();
  const navigate = useNavigate();
  const form = useForm();
  const submit = useCallback(() => {
    form.setLoading(true)
    form.setFormErrors(null)
    AuthencationService.forgetPassword(form.formData).then((data) => {
      openPopup({
        type: 'success',
        message: 'You has been created, please check inbox your email to active account',
        onConfirm: () => {
          navigate('/login')
        }
      })
      form.setLoading(false)
    }).catch((error) => {
      if (error.response.data?.errors) {
        form.setFormErrors(error.response.data?.errors)
      }
      if(error.response.data?.message) {
        openPopup({
          type: 'error',
          message: error.response.data?.message
        })
      }
      form.setLoading(false)
    })
  }, [form.formData]);
  return (
    <AuthLayout>
      <div className="auth-page-card">
        <h2 className="auth-page-title theme-title h3">Welcome Back</h2>
        <p className="auth-page-subtitle theme-title ">Sign in to your account to continue</p>

        <div>
          <div className="mb-3">
            <InputForm 
              name="email"
              value={form.formData?.email} 
              errorMessage={form.formErrors?.email} 
              handleChange={form.handleChange}
              type="email" 
              placeholder="Your email" />
          </div>

          <div className="d-flex justify-content-between align-items-center mb-3">
            <a href="#" className="text-decoration-none text-primary" style={{

            }}>Forgot password?</a>
          </div>

          <GradientButton loading={form.loading} width={'100%'} callback={submit} text="Sign In" />

          <div className="auth-page-footer-text">
            Don’t have an account? <Link to="/login">Sign in</Link>
          </div>
        </div>
      </div>
    </AuthLayout>
  );
}
