import React, { useRef, useState } from 'react'
import EntityIconType from './EntityIconType'
import EntityMessage from './EntityMessage'
import { usePopup } from '../popups/PopupContext';
import { useDispatch } from 'react-redux';
import { decrementNotificationCount } from '../../redux/NotificationSlice';
export default function ListItem({
    entity = null,
    update = (item) => { },
    destroy = (item) => { }
}) {
    const dispatch = useDispatch();
    const { openPopup } = usePopup();
    const [item,setItem] = useState(entity);
    const confirmMarkRead = () => {
        openPopup({
            type: 'warning',
            message: 'Are your sure confirm to readed',
            onConfirm: () => {
                //item.is_read = true;
                setItem((pre) => {
                    pre.is_read = true;
                    return pre;
                });
                dispatch(decrementNotificationCount())
                update(entity);
            }
        })
    }
    const confirmDelete = () => {
        openPopup({
            type: 'warning',
            message: 'Are your sure confirm to delete',
            onConfirm: () => {
                setItem(null);
                destroy(entity);
            }
        })
    }
    return item ? <div
        className="d-flex align-items-start justify-content-between p-3 mb-3 rounded notification-item theme-sidebar-bg theme-title"
    >
        <div className="d-flex align-items-start">
            <div
                className="rounded-circle d-flex justify-content-center align-items-center me-3 theme-title"
                style={{
                    width: "36px",
                    height: "36px",
                    flexShrink: 0,
                }}
            >
                <EntityIconType type={item.type} entity_type={item.entity_type} />
            </div>
            <div>
                <div className="theme-title-highlight fw-semibold text-uppercase">
                    {item.title ?? item.entity_type}{" "}#{item.entity_id}
                    {!item.is_read ? (
                        <span
                            className="text-danger ms-1"
                            style={{
                                fontSize: "10px",
                                verticalAlign: "middle",
                            }}
                        >
                            ●
                        </span>
                    ) : null}
                </div>
                <div className="theme-title small">
                    <EntityMessage entity={item} />
                </div>
                <div className="theme-title small mt-1">{item.created_at_human}</div>
            </div>
        </div>
        <div className="text-end">
            {!item.is_read ? (
                <button
                    onClick={confirmMarkRead}
                    className="btn btn-link btn-sm text-decoration-none text-info"
                    style={{ fontSize: "0.85rem" }}
                >
                    Mark as read
                </button>
            ) : null}
            <button
                onClick={confirmDelete}
                className="btn btn-link btn-sm text-decoration-none text-danger"
                style={{ fontSize: "0.85rem" }}
            >
                Delete
            </button>
        </div>
    </div> : null;

}