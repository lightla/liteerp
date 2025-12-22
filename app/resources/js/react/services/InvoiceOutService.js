import api from "../common/api";
const InvoiceOutService = {
  add: (data) => api.post("/business-access/invoice-outs",data),
  show: (id) => api.get("/business-access/invoice-outs/" + id),
  list: ({
    keywords = '',
    payment_status = '',
    order_by = '',
    page = 0
  }) => api.get("/business-access/invoice-outs" 
    + `?page=${page}&keywords=${keywords}
      &payment_status=${payment_status}&order_by=${order_by}`),
  update: (data) => api.put("/business-access/invoice-outs/" + data.id,data)
};
export default InvoiceOutService;
