import api from "../common/api";

 const PriceListService = {
  add: (data) => api.post("/business-access/price-lists",data),
  show: (id) => api.get("/business-access/price-lists/" + id),
  list: (data) => api.get("/business-access/price-lists" 
      + `?keywords=${data.keywords}&page=${data.page}`),
  update: (data) => api.put("/business-access/price-lists/" + data.id,data),
};
export default PriceListService;