import api from "../common/api";

 const ProductService = {
  add: (data) => api.post("/business-access/products",data),
  show: (id) => api.get("/business-access/products/" + id),
  list: (data) => api.get("/business-access/products" 
    + `?keywords=${data.keywords}&page=${data.page}`),
  listByPurchaseId: (data) => api.get("/business-access/products" + 
    `?purchase_id=${data.purchase_id}&keywords=${data.keywords}&page=${data.page}&active=${data.active}`),
  addCategory: (data) => api.post("/business-access/category-product",data),
  updateCategory: (data) => api.put("/business-access/category-product/" + data.id,data),
  listCategory: (data) => api.get("/business-access/category-product?keywords=" + `${data.keywords}&page=${data.page}`),
  update: (data) => api.put("/business-access/products/" + data.id,data),
  delete: (data) => api.delete("/business-access/products/" + data.id),
  deleteCategory: (data) => api.delete("/business-access/category-product/" + data.id),
};
export default ProductService;