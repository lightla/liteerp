import api from "../common/api";

 const StockOutService = {
  add: (data) => api.post("/business-access/stocks/outs",data),
  show: (id) => api.get("/business-access/stocks/outs/" + id),
  list: (data) => api.get("/business-access/stocks/outs"
    + `?page=${data.page}&keywords=${data.keywords}
      &status=${data.status}&order_by=${data.order_by}`),
  update: (data) => api.put("/business-access/stocks/outs/" + data.id,data),
};
export default StockOutService;