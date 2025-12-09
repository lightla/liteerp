import React, { useState, useEffect, useCallback } from "react";
import GradientButton from "../components/UI/Buttons/GradientButton";
import AuthencationService from "../services/AuthencationService";
import AuthLayout from "../layouts/AuthLayout";
import { Link, useNavigate } from "react-router-dom";
import { usePopup } from '../components/popups/PopupContext'
import { useForm } from '../libraries/handleInput'
import { InputForm } from '../components/UI/Input/InputForm'
export default function Login() {
  const navigate = useNavigate();
  const { openPopup } = usePopup();
  const form = useForm();
  const submit = useCallback(async () => {
    form.setLoading(true)
    AuthencationService.login(form.formData).then((data) => {
      form.setLoading(false)
      localStorage.setItem('token', data?.message?.token)
      navigate('/business')
    }).catch((error) => {
      form.setLoading(false)
      if (error.response.data?.errors) {
        form.setFormErrors(error.response.data?.errors)
      }
      if (error.response.data?.message) {
        openPopup({
          message: error.response.data?.message,
          type: 'error'
        })
      }
    })
  }, [form.formData, openPopup]);
  return (
    <AuthLayout>
      <div>
        
        <div className="auth-page-card">
          <h2 className="auth-page-title theme-title h3">Welcome Back</h2>
          <p className="auth-page-subtitle theme-title ">Sign in to your account to continue</p>

          <div>
            <div className="mb-3">
              <InputForm
                name="email"
                handleChange={form.handleChange}
                errorMessage={form.formErrors?.email}
                type="email"
                value={form.formData?.email}
                placeholder="Your email" />
            </div>
            <div className="mb-3 position-relative">
              <InputForm
                name="password"
                handleChange={form.handleChange}
                errorMessage={form.formErrors?.password}
                value={form.formData?.password}
                type="password"
                placeholder="Your password" />
            </div>

            <div className="d-flex justify-content-between align-items-center mb-3">
              <Link to={'/forget-password'} className="text-decoration-none text-primary" style={{

              }}>Forgot password?</Link>
            </div>

            <GradientButton loading={form.loading} width={'100%'} callback={submit} text="Sign In" />

            <div className="auth-page-footer-text">
              Don’t have an account? <Link to="/register">Sign up</Link>
            </div>
          </div>
        </div>
      </div>
    </AuthLayout>
  );
}
