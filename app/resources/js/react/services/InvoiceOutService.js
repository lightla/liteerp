import api from "../common/api";
const InvoiceOutService = {
  add: (data) => api.post("/business-access/invoice-outs",data),
  show: (id) => api.get("/business-access/invoice-outs/" + id),
  list: (data) => api.get("/business-access/invoice-outs" + `?page=${data.page}&keywords=${data.keywords}&status=${data.status}`),
  update: (data) => api.put("/business-access/invoice-outs/" + data.id,data)
};
export default InvoiceOutService;
