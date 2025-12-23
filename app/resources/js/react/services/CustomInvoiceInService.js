import api from "../common/api";
const CustomInvoiceInService = {
  add: (data) => api.post("/business-access/custom-invoice-ins",data),
  show: (id) => api.get("/business-access/custom-invoice-ins/" + id),
  list: ({
    keywords = '',
    payment_status = '',
    order_by = '',
    page = 0
  }) => api.get("/business-access/custom-invoice-ins" 
    + `?page=${page}&keywords=${keywords}
      &payment_status=${payment_status}&order_by=${order_by}`),
  update: (data) => api.put("/business-access/custom-invoice-ins/" + data.id,data),
  delete: (data) => api.delete("/business-access/custom-invoice-ins/" + data.id)
};
export default CustomInvoiceInService;
