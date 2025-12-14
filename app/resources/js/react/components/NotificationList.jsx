import React, { useCallback, useEffect, useRef, useState } from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import NotificationService from "../services/NotificationService";
import useTable from '../libraries/handleTable'
import { usePopup } from '../components/popups/PopupContext'
import LoadingBox from './LoadingBox'
import ListItem from "./NotificationList/ListItem";
import {useForm} from '../libraries/handleInput';
import {Select} from '../components/UI/Input/Select'
const NotificationList = () => {
  const [loading,setLoading] = useState(false);
  const [types,setTypes] = useState([]);
  const table = useTable();
  const search = useForm();
  const { openPopup } = usePopup();
  const getListType = useCallback(() => {
    NotificationService.listType()
      .then((resp) => {
        setTypes(resp.message)
      })
      .catch((error) => {
        
      })
  },[]);
  const getNotifications = useCallback(() => {
    setLoading(true)
    NotificationService.list({
      page: 0,
      type: search.formData?.type ?? ''
    })
      .then((resp) => {
        table.setData(resp.message.data);
        table.setTotal(resp.message.total);
        setLoading(false)
      })
      .catch((error) => {
        if (error.response?.data?.message) {
          openPopup({
            type: 'error',
            message: error.response?.data?.message
          })
        }
        setLoading(false)
      })
  }, [search.formData?.type]);
  const update = useCallback((row) => {
    NotificationService.update(row)
      .then((resp) => {
      })
      .catch((error) => {
        if (error.response?.data?.message) {
          openPopup({
            type: 'error',
            message: error.response?.data?.message
          })
        }
      })
  }, [])
  const destroy = useCallback((row) => {
    NotificationService.delete(row)
      .then((resp) => {
      })
      .catch((error) => {
        if (error.response?.data?.message) {
          openPopup({
            type: 'error',
            message: error.response?.data?.message
          })
        }
      })
  }, [])
  
  useEffect(() => {
    getNotifications();
    getListType();
    
  }, [search.formData?.type])

  return (
    <div
      className="container-fluid py-4"
      style={{ minHeight: "100vh" }}
    >
      <div className="mx-auto col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div className="d-flex justify-content-between align-items-center mb-3">
          <h5 className="theme-title-highlight mb-0">All Notifications</h5>
          <div className="d-flex align-items-center">
            <span className="badge bg-secondary me-2">
              {table.data.length} notifications
            </span>
            {/* <select
              className="form-select form-select-sm border-secondary"
              style={{ width: "130px" }}
            >
              <option>All</option>
              {types.map((item,index) => {
                return <option key={index}>{item.entity_type}</option>
              })}
            </select> */}
            <Select className="form-select form-select-sm border-secondary"
            name="type"
            handleChange={search.handleChange}
            value={search.formData?.type}
            errorMessage={search.formErrors?.type}
            options={types.map((item,index) => {
              return {
                value: item.entity_type,
                label: item.entity_type
              }
            })}
            />
          </div>
        </div>
        {loading ? <LoadingBox/> : table.data.map((n, key) => (
          <div key={key}>
            <ListItem update={update} destroy={destroy} entity={n}/>
          </div>
        ))}
        
        
      </div>
    </div>
  );
};

export default NotificationList;
