import React, { useContext } from "react";
import { Link, useLocation } from "react-router-dom";
import { AdminAuthContext } from "../context/AdminAuth";

const Sidebar = () => {
  const { logout } = useContext(AdminAuthContext);

  const location = useLocation();
  const isActive = (path) => location.pathname === path;

  return (
    <div className="card shadow mb-5 sidebar">
      <div className="card-body p-4">
        <ul>
          <li>
            <Link
              className={`${isActive('/admin/dashboard') ? 'active' : ''}`}
              to="/admin/dashboard"
            >
              Dashboard
            </Link>
          </li>
          <li>
            <Link className={`${isActive('/admin/categories') ? 'active' : ''}`} to="/admin/categories">Categories</Link>
          </li>
          <li>
            <Link className={`${isActive('/admin/brands') ? 'active' : ''}`} to="/admin/brands">Brands</Link>
          </li>
          <li>
            <Link className={`${isActive('/admin/sizes') ? 'active' : ''}`} to="/admin/sizes">Sizes</Link>
          </li>
          <li>
            <Link className={`${isActive('/admin/products') ? 'active' : ''}`} to="/admin/products">Products</Link>
          </li>
          <li>
            <Link to="">Orders</Link>
          </li>
          <li>
            <Link to="">Users</Link>
          </li>
          <li>
            <Link to="">Shipping</Link>
          </li>
          <li>
            <Link to="">Change Password</Link>
          </li>
          <li>
            <a href="javascript:;" onClick={logout}>
              LogOut
            </a>
          </li>
        </ul>
      </div>
    </div>
  );
};

export default Sidebar;
