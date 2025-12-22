import api from "../common/api";

 const ActivityLogService = {
  list: ({
    page = 0
  }) => api.get("/business-access/activity-logs?page=" + page)
};
export default ActivityLogService;