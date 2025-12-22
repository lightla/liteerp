import api from "../common/api";

 const StockOutService = {
  add: (data) => api.post("/business-access/stocks/outs",data),
  show: (id) => api.get("/business-access/stocks/outs/" + id),
  list: ({
    page = 0,
    keywords = '',
    status = '',
    order_by = ''
  }) => api.get("/business-access/stocks/outs"
    + `?page=${page}&keywords=${keywords}
      &status=${status}&order_by=${order_by}`),
  update: (data) => api.put("/business-access/stocks/outs/" + data.id,data),
};
export default StockOutService;