import api from "../common/api";

 const StockInService = {
  add: (data) => api.post("/business-access/stocks/ins",data),
  show: (id) => api.get("/business-access/stocks/ins/" + id),
  list: ({
    keywords = '',
    page = 0,
    status = '',
    order_by = ''
  }) => api.get("/business-access/stocks/ins"
    + `?page=${page}&keywords=${keywords}
      &status=${status}&order_by=${order_by}`),
  update: (data) => api.put("/business-access/stocks/ins/" + data.id,data),
};
export default StockInService;