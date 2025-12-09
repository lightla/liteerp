import React from "react";
import "bootstrap/dist/css/bootstrap.min.css";

const NotificationList = () => {
  const notifications = [
    {
      id: 1,
      icon: "bi-bag",
      color: "#0d6efd",
      title: "New Order #DH001",
      desc: "Customer ABC Corp just placed an order",
      time: "5 minutes ago",
      unread: true,
    },
    {
      id: 2,
      icon: "bi-exclamation-triangle-fill",
      color: "#ffc107",
      title: "Low Stock Warning",
      desc: "Product XYZ is almost out of stock",
      time: "1 hour ago",
      unread: true,
    },
    {
      id: 3,
      icon: "bi-cash-coin",
      color: "#0dcaf0",
      title: "Payment Successful",
      desc: "Received 15,000,000 VND",
      time: "3 hours ago",
    },
    {
      id: 4,
      icon: "bi-bag",
      color: "#0d6efd",
      title: "New Order #DH002",
      desc: "Customer DEF Ltd placed an order",
      time: "3 hours ago",
    },
    {
      id: 5,
      icon: "bi-person-circle",
      color: "#6f42c1",
      title: "New Customer",
      desc: "GHI Company has registered an account",
      time: "4 hours ago",
    },
    {
      id: 6,
      icon: "bi-exclamation-octagon-fill",
      color: "#ffc107",
      title: "System Warning",
      desc: "Server storage is almost full",
      time: "5 hours ago",
    },
    {
      id: 7,
      icon: "bi-cash-stack",
      color: "#0dcaf0",
      title: "Payment Successful",
      desc: "Received 8,500,000 VND",
      time: "6 hours ago",
    },
    {
      id: 8,
      icon: "bi-x-circle-fill",
      color: "#dc3545",
      title: "Order Cancelled #DH003",
      desc: "Customer JKL Corp cancelled the order",
      time: "1 day ago",
    },
  ];

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
              {notifications.length} notifications
            </span>
            <select
              className="form-select form-select-sm border-secondary"
              style={{ width: "130px" }}
            >
              <option>All</option>
              <option>Orders</option>
              <option>Payments</option>
              <option>Warnings</option>
              <option>Customers</option>
              <option>Cancelled</option>
            </select>
          </div>
        </div>

        {notifications.map((n) => (
          <div
            key={n.id}
            className="d-flex align-items-start justify-content-between p-3 mb-3 rounded notification-item theme-sidebar-bg theme-title"
          >
            <div className="d-flex align-items-start">
              <div
                className="rounded-circle d-flex justify-content-center align-items-center me-3 theme-title"
                style={{
                  width: "36px",
                  height: "36px",
                  backgroundColor: n.color,
                  flexShrink: 0,
                }}
              >
                <i className={`bi ${n.icon} theme-title-highlight`}></i>
              </div>
              <div>
                <div className="theme-title-highlight fw-semibold">
                  {n.title}{" "}
                  {n.unread && (
                    <span
                      className="text-danger ms-1"
                      style={{
                        fontSize: "10px",
                        verticalAlign: "middle",
                      }}
                    >
                      ●
                    </span>
                  )}
                </div>
                <div className="theme-title small">{n.desc}</div>
                <div className="theme-title small mt-1">{n.time}</div>
              </div>
            </div>
            <div className="text-end">
              {n.unread && (
                <button
                  className="btn btn-link btn-sm text-decoration-none text-info"
                  style={{ fontSize: "0.85rem" }}
                >
                  Mark as read
                </button>
              )}
              <button
                className="btn btn-link btn-sm text-decoration-none text-danger"
                style={{ fontSize: "0.85rem" }}
              >
                Delete
              </button>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default NotificationList;
