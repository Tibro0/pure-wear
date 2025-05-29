import { useState } from 'react'
import { BrowserRouter, Route, Routes } from 'react-router-dom'
import Home from './components/Home'
import Shop from './components/Shop'
import Product from './components/Product'
import Cart from './components/Cart'
import Checkout from './components/Checkout'
import Login from './components/admin/Login'
import { ToastContainer, toast } from 'react-toastify';
import Dashboard from './components/admin/Dashboard'
import { AdminRequireAuth } from './components/admin/AdminRequireAuth'

import { default as ShowCategories } from './components/admin/category/Show'
import { default as CreateCategory } from './components/admin/category/Create'
import { default as EditCategory } from './components/admin/category/Edit'

import { default as ShowBrands } from './components/admin/brand/Show'
import { default as CreateBrand } from './components/admin/brand/Create'
import { default as EditBrand } from './components/admin/brand/Edit'

import { default as ShowSizes } from './components/admin/size/Show'
import { default as CreateSize } from './components/admin/size/Create'
import { default as EditSize } from './components/admin/size/Edit'

import { default as ShowProducts } from './components/admin/product/Show'
import { default as CreateProduct } from './components/admin/product/Create'
import { default as EditProduct } from './components/admin/product/Edit'

function App() {

  return (
    <>
      <BrowserRouter>
        <Routes>
          <Route path='/' element={<Home />} />
          <Route path='/shop' element={<Shop />} />
          <Route path='/product' element={<Product />} />
          <Route path='/cart' element={<Cart />} />
          <Route path='/checkout' element={<Checkout />} />
          {/* Admin Routs */}
          <Route path='/admin/login' element={<Login />} />
          <Route path='/admin/dashboard' element={
            <AdminRequireAuth>
              <Dashboard />
            </AdminRequireAuth>
          } />

          {/* Categories Route Start */}
          <Route path='/admin/categories' element={
            <AdminRequireAuth>
              <ShowCategories />
            </AdminRequireAuth>
          } />
          <Route path='/admin/categories/create' element={
            <AdminRequireAuth>
              <CreateCategory />
            </AdminRequireAuth>
          } />
          <Route path='/admin/categories/edit/:id' element={
            <AdminRequireAuth>
              <EditCategory />
            </AdminRequireAuth>
          } />
          {/* Categories Route End */}

          {/* Brands Route Start */}
          <Route path='/admin/brands' element={
            <AdminRequireAuth>
              <ShowBrands />
            </AdminRequireAuth>
          } />
          <Route path='/admin/brands/create' element={
            <AdminRequireAuth>
              <CreateBrand />
            </AdminRequireAuth>
          } />
          <Route path='/admin/brands/edit/:id' element={
            <AdminRequireAuth>
              <EditBrand />
            </AdminRequireAuth>
          } />
          {/* Brands Route End */}

          {/* Sizes Route Start */}
          <Route path='/admin/sizes' element={
            <AdminRequireAuth>
              <ShowSizes />
            </AdminRequireAuth>
          } />
          <Route path='/admin/sizes/create' element={
            <AdminRequireAuth>
              <CreateSize />
            </AdminRequireAuth>
          } />
          <Route path='/admin/sizes/edit/:id' element={
            <AdminRequireAuth>
              <EditSize />
            </AdminRequireAuth>
          } />
          {/* Sizes Route End */}

          {/* Products Route Start */}
          <Route path='/admin/products' element={
            <AdminRequireAuth>
              <ShowProducts />
            </AdminRequireAuth>
          } />
          <Route path='/admin/products/create' element={
            <AdminRequireAuth>
              <CreateProduct />
            </AdminRequireAuth>
          } />
          <Route path='/admin/products/edit/:id' element={
            <AdminRequireAuth>
              <EditProduct />
            </AdminRequireAuth>
          } />
          {/* Products Route End */}

        </Routes>
      </BrowserRouter>

      <ToastContainer />
    </>
  )
}

export default App
