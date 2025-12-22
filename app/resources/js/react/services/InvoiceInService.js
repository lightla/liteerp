import api from "../common/api";

const InvoiceInService = {
  add: (data) => api.post("/business-access/invoice-ins",data),
  show: (id) => api.get("/business-access/invoice-ins/" + id),
  list: ({
    keywords = '',
    payment_status =  '',
    order_by = '',
    page = 0
  }) => api.get("/business-access/invoice-ins" 
      + `?page=${page}&keywords=${keywords}
      &payment_status=${payment_status}&order_by=${order_by}`),
  update: (data) => api.put("/business-access/invoice-ins/" + data.id,data)
};
export default InvoiceInService;
