import React from "react";
import DashboardLayout from "../layouts/DashboardLayout";
import CommonDataTable from "../components/CommonDataTable";
import { formatMoney } from "../libraries/common";

export default function Branch() {
  // 🔹 Cấu hình cột cho bảng chi nhánh
  const columns = [
    { label: "Mã chi nhánh", key: "id" },
    { label: "Tên chi nhánh", key: "name" },
    { label: "Người quản lý", key: "manager" },
    { label: "Số điện thoại", key: "phone" },
    { label: "Địa chỉ", key: "address" },
    {
      label: "Doanh thu tháng này",
      key: "monthly_revenue",
      render: (value) => <strong>{formatMoney(value)}</strong>,
    },
    {
      label: "Trạng thái",
      key: "status",
      render: (value) => (
        <span
          className={`badge rounded-pill px-3 py-2 ${
            value === "active"
              ? "bg-success bg-opacity-75"
              : "bg-secondary text-light"
          }`}
        >
          {value === "active" ? "Đang hoạt động" : "Tạm dừng"}
        </span>
      ),
    },
  ];

  // 🔹 Dữ liệu mẫu chi nhánh
  const data = [
    {
      id: "BR001",
      name: "Chi nhánh Hà Nội",
      manager: "Nguyễn Văn An",
      phone: "024-3876-1122",
      address: "Số 12 Nguyễn Trãi, Thanh Xuân, Hà Nội",
      monthly_revenue: 185000000,
      status: "active",
    },
    {
      id: "BR002",
      name: "Chi nhánh Đà Nẵng",
      manager: "Trần Thị Bích",
      phone: "0236-378-2245",
      address: "45 Nguyễn Văn Linh, Hải Châu, Đà Nẵng",
      monthly_revenue: 94000000,
      status: "active",
    },
    {
      id: "BR003",
      name: "Chi nhánh TP. Hồ Chí Minh",
      manager: "Lê Văn Cường",
      phone: "028-6258-7788",
      address: "200 Điện Biên Phủ, Bình Thạnh, TP.HCM",
      monthly_revenue: 235000000,
      status: "active",
    },
    {
      id: "BR004",
      name: "Chi nhánh Cần Thơ",
      manager: "Phạm Minh Tân",
      phone: "0292-377-8899",
      address: "15 Nguyễn Văn Cừ, Ninh Kiều, Cần Thơ",
      monthly_revenue: 55000000,
      status: "inactive",
    },
  ];

  // 🔹 Xử lý hành động
  const handleEdit = (row) => {
    console.log("Edit clicked:", row);
  };

  const handleDelete = (row) => {
    console.log("Delete clicked:", row);
  };

  return (
    <DashboardLayout>
      <div className="m-4">
        {/* --- Header --- */}
        <div className="d-flex justify-content-between align-items-center">
          <div>
            <h5 className="fw-bold mb-2 theme-title">Quản lý chi nhánh</h5>
            <p className="theme-title mb-4">
              Theo dõi tình hình hoạt động và doanh thu của từng chi nhánh
            </p>
          </div>
          <div>
            <span className="h6 badge bg-primary btn mx-2">
              <strong>Thêm mới chi nhánh</strong>
            </span>
          </div>
        </div>

        {/* --- Bảng chi nhánh --- */}
        <CommonDataTable
          columns={columns}
          data={data}
          onEdit={handleEdit}
          onDelete={handleDelete}
        />
      </div>
    </DashboardLayout>
  );
}
