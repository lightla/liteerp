import React, { useState, useEffect, useCallback } from "react";
import GradientButton from "../components/UI/Buttons/GradientButton";
import AuthencationService from "../services/AuthencationService";
import AuthLayout from "../layouts/AuthLayout";
import { Link, useNavigate } from "react-router-dom";
import { usePopup } from '../components/popups/PopupContext'
import { useForm } from "../libraries/handleInput";
import { InputForm } from "../components/UI/Input/InputForm";
export default function Register() {
  const { openPopup } = usePopup();
  const navigate = useNavigate();
  const form = useForm();
  const submit = useCallback(async () => {
    form.setLoading(true)
    form.setFormErrors(null)
    AuthencationService.register(form.formData).then((data) => {
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
              name="name"
              handleChange={form.handleChange}
              value={form.formData?.name} 
              errorMessage={form.formErrors?.name} 
              type="text" 
              placeholder="Your name" />
          </div>
          <div className="mb-3">
            <InputForm 
              name="email"
              handleChange={form.handleChange}
              value={form.formData?.email} 
              errorMessage={form.formErrors?.email} 
              type="email" 
              placeholder="Your email" />
          </div>
          <div className="mb-3 position-relative">
            <InputForm 
              name="password"
              handleChange={form.handleChange}
              value={form.formData?.password} 
              errorMessage={form.formErrors?.password} 
              type="password" 
              placeholder="Your password" />
          </div>
          <div className="mb-3 position-relative">
            <InputForm 
              name="password_confirmation"
              handleChange={form.handleChange}
              value={form.formData?.password_confirmation} 
              errorMessage={form.formErrors?.password_confirmation}  
              type="password" placeholder="Confirm password" />
          </div>

          <div className="d-flex justify-content-between align-items-center mb-3">
            <Link to="/forget-password" className="text-decoration-none text-primary" style={{

            }}>Forgot password?</Link>
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
