import api from "../common/api";

const InvoiceInService = {
  add: (data) => api.post("/business-access/invoice-ins",data),
  show: (id) => api.get("/business-access/invoice-ins/" + id),
  list: (data) => api.get("/business-access/invoice-ins" 
      + `?page=${data.page}&keywords=${data.keywords}&payment_status=${data.payment_status}`),
  update: (data) => api.put("/business-access/invoice-ins/" + data.id,data)
};
export default InvoiceInService;
