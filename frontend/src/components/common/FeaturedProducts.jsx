import React from 'react'
import ProductImg from '../../assets/images/eleven.jpg'
import { Link } from 'react-router-dom'

const FeaturedProducts = () => {
    return (
        <section className='section-2 py-5'>
            <div className='container'>
                <h2>Featured Products</h2>
                <div className='row mt-4'>
                    <div className='col-md-3 col-6'>
                        <div className='product card border-0'>
                            <div className='card-img'>
                                <Link to="/product">
                                    <img src={ProductImg} alt="" className='w-100' />
                                </Link>
                            </div>
                            <div className='card-body pt-3'>
                                <Link to="/product">Red Check Shirt For Men</Link>
                                <div className='price'>
                                    $50 <span className='text-decoration-line-through'>$80</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className='col-md-3 col-6'>
                        <div className='product card border-0'>
                            <div className='card-img'>
                                <Link to="/product">
                                    <img src={ProductImg} alt="" className='w-100' />
                                </Link>
                            </div>
                            <div className='card-body pt-3'>
                                <Link to="/product">Red Check Shirt For Men</Link>
                                <div className='price'>
                                    $50 <span className='text-decoration-line-through'>$80</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className='col-md-3 col-6'>
                        <div className='product card border-0'>
                            <div className='card-img'>
                                <Link to="/product">
                                    <img src={ProductImg} alt="" className='w-100' />
                                </Link>
                            </div>
                            <div className='card-body pt-3'>
                                <Link to="/product">Red Check Shirt For Men</Link>
                                <div className='price'>
                                    $50 <span className='text-decoration-line-through'>$80</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className='col-md-3 col-6'>
                        <div className='product card border-0'>
                            <div className='card-img'>
                                <Link to="/product">
                                    <img src={ProductImg} alt="" className='w-100' />
                                </Link>
                            </div>
                            <div className='card-body pt-3'>
                                <Link to="/product">Red Check Shirt For Men</Link>
                                <div className='price'>
                                    $50 <span className='text-decoration-line-through'>$80</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    )
}

export default FeaturedProducts
