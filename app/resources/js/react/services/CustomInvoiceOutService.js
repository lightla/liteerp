import api from "../common/api";
const CustomInvoiceOutService = {
  add: (data) => api.post("/business-access/custom-invoice-outs",data),
  show: (id) => api.get("/business-access/custom-invoice-outs/" + id),
  list: ({
    keywords = '',
    payment_status = '',
    order_by = '',
    page = 0
  }) => api.get("/business-access/custom-invoice-outs" 
    + `?page=${page}&keywords=${keywords}
      &payment_status=${payment_status}&order_by=${order_by}`),
  update: (data) => api.put("/business-access/custom-invoice-outs/" + data.id,data),
  delete: (data) => api.delete("/business-access/custom-invoice-outs/" + data.id)
};
export default CustomInvoiceOutService;
