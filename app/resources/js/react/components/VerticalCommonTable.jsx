import React from "react";

const VerticalCommonTable = ({ data = [] }) => {
  return (
    <table className="table table-bordered rounded-4">
      <tbody>
        {Object.entries(data).map(([key, value]) => (
          <tr key={key}>
            <th className="text-capitalize" style={{ width: "40%" }}>
              {key.replace(/_/g, " ")}
            </th>
            <td>{value}</td>
          </tr>
        ))}
      </tbody>
    </table>
  );
};

export default VerticalCommonTable;
